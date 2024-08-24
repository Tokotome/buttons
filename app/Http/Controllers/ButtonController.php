<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Button;
use Illuminate\Support\Facades\Validator;

class ButtonController extends Controller
{
    /**
     * Display a listing of the buttons.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $buttons = Button::all()->map(function($button) {
            $button->name = $this->extractDomainPart($button->hyperlink);
            return $button;
        });
    
        return view('buttons.buttons', compact('buttons'));
    }

    public function edit($id)
    {
        $button = Button::findOrFail($id);
        return view('buttons.edit', compact('button'));
    }

    /**
     * Update the specified button in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $button = Button::findOrFail($id);

        $rules = [
            'position' => 'required|integer|between:1,9',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'hyperlink' => 'nullable|url',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['position', 'color', 'hyperlink']);
        if (empty($data['hyperlink'])) {
            $data['hyperlink'] = '';
        }

        $button->update($data);

        return redirect()->route('buttons.index')->with('success', 'Button updated successfully.');
        }

    /**
     * Remove the specified configuration of the button.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $button = Button::findOrFail($id);

        $button->color = '#ffffff';
        $button->hyperlink = '';
        $button->save();

        return response()->json([
            'success' => true,
            'message' => 'Button updated successfully.',
            'button_name' => '',
        ]);
    }

    /**
     * Extract domain or subdomain part from a URL.
     * This can me moved to a separate helper folder to cover possible scalability of the project and reusability
     *
     * @param  string  $url
     * @return string
     */
    private function extractDomainPart($url)
    {
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'] ?? '';
        $hostParts = explode('.', $host);

        if (count($hostParts) > 2) {
            $tld = array_pop($hostParts);
            $mainDomain = array_pop($hostParts);

            if ($hostParts[0] === 'www') {
                array_shift($hostParts);
            }

            $subdomain = implode('.', $hostParts);

            return $subdomain ?: $mainDomain;
        }

        if (count($hostParts) == 2) {
            return $hostParts[0];
        }

        return '';
    }
}
