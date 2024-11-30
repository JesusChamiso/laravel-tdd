<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepositoryController extends Controller {

    public function store(Request $request) {
        $request->validate([
            'url' => 'required',
            'description' => 'required'
        ]);
        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function update(Request $request, Repository $repository) {
        $request->validate([
            'url' => 'required',
            'description' => 'required'
        ]);
        if ($request->user()->id != $repository->user_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $repository->update($request->all());
        return redirect()->route('repositories.edit', $repository);
    }

    public function destroy(Repository $repository, Request $request) {
        if ($request->user()->id != $repository->user_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $repository->delete();
        return redirect()->route('repositories.index');
    }
}
