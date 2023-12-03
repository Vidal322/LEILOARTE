<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

class FAQController extends Controller
{

    public static function returnFAQ($id)
    {
      $faq = FAQ::find($id);
      return $faq;
    }

    public function list()
    {
      $faqs = FAQ::all();
      return view('pages.faq', ['faqs' => $faqs]);
    }

    public function showEditForm($id)
    {
      $faq = FAQ::find($id);
      try {
        $this->authorize('edit', $faq);
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }

      return view('pages.editFAQ', ['id' => $id]);
    }

    public function edit(Request $request, $id)
    {
      $faq = FAQ::find($id);
      $faq->question = $request->input('question');
      $faq->answer = $request->input('answer');
      try {
        $this->authorize('edit', $faq);
        $faq->update();
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }
      catch (QueryException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
      }

      return redirect('faqs');
    }

    public function delete($id)
    {
      $faq = FAQ::find($id);
      try {
        $this->authorize('delete', $faq);
        $faq->delete();
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }
      catch (QueryException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
      }

      return redirect('faqs');
    }
}