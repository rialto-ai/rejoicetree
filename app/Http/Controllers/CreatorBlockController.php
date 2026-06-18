<?php

namespace App\Http\Controllers;

use App\Models\Button;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Structured Rejoice link blocks. Each block is a LinkStack Link row tagged
 * with a block_type and (optionally) block-specific fields stored as JSON in
 * block_params.
 */
class CreatorBlockController extends Controller
{
    public function index()
    {
        $blocks = Link::where('user_id', Auth::id())
            ->whereNotNull('block_type')
            ->orderBy('order')
            ->get();

        return view('creator.blocks', [
            'blocks' => $blocks,
            'blockTypes' => config('rejoice.block_types'),
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'Custom Link');
        if (!in_array($type, config('rejoice.block_types'), true)) {
            $type = 'Custom Link';
        }

        return view('creator.block-edit', $this->formData($type, null));
    }

    public function edit($id)
    {
        $block = Link::where('user_id', Auth::id())->findOrFail($id);

        return view('creator.block-edit', $this->formData($block->block_type ?: 'Custom Link', $block));
    }

    public function store(Request $request)
    {
        $type = $request->input('block_type');
        abort_unless(in_array($type, config('rejoice.block_types'), true), 422);

        $data = $request->validate([
            'block_type' => ['required', Rule::in(config('rejoice.block_types'))],
            'title' => 'required|string|max:190',
            'link' => 'nullable|string|max:2000',
        ]);

        $id = $request->input('id');
        $block = $id
            ? Link::where('user_id', Auth::id())->findOrFail($id)
            : new Link();

        if (!$id) {
            $block->user_id = Auth::id();
            $block->button_id = Button::where('name', 'custom_website')->value('id') ?? Button::first()->id;
        }

        // Collect block-specific fields declared in config.
        $params = [];
        foreach (config('rejoice.block_fields.' . $type, []) as $field) {
            $params[$field] = $request->input("params.$field");
        }

        $block->block_type = $type;
        $block->title = $data['title'];
        $block->link = ($data['link'] ?? null) ?: ($params['support_url'] ?? $params['ticket_url'] ?? $params['booking_url'] ?? '#');
        $block->block_params = json_encode($params);

        // Support-block safety: flag for review when claiming tax deductibility
        // or when the platform requires review of all support links.
        if ($type === 'Support') {
            $block->support_type = $params['support_type'] ?? null;
            $block->support_entity_name = $params['support_entity_name'] ?? null;
            $block->tax_deductible_claimed = !empty($params['tax_deductible_claimed']);
            $needsReview = $block->tax_deductible_claimed
                || rejoice_setting('require_review_for_support_links')
                || !empty($params['review_required']);
            $block->review_required = $needsReview;
            $block->review_status = $needsReview ? 'Unreviewed' : ($block->review_status ?: 'Unreviewed');
        }

        $block->save();

        return redirect()->route('creator.blocks')->with('success', "Your {$type} block has been saved.");
    }

    public function destroy($id)
    {
        $block = Link::where('user_id', Auth::id())->findOrFail($id);
        $block->delete();

        return redirect()->route('creator.blocks')->with('success', 'Block removed.');
    }

    private function formData(string $type, ?Link $block): array
    {
        return [
            'block' => $block,
            'type' => $type,
            'fields' => config('rejoice.block_fields.' . $type, []),
            'params' => $block ? $block->blockParams() : [],
            'supportTypes' => config('rejoice.support_types'),
            'bookingTypes' => config('rejoice.booking_types'),
        ];
    }
}
