<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepositoryController extends Controller {


    public function index(Request $request) {
        return view('repositories.index', ['repositories' => $request->user()->repositories]);
    }

    public function show(Request $request, Repository $repository) {
        if ($request->user()->id != $repository->user_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('repositories.show', compact('repository'));
    }

    public function edit(Request $request, Repository $repository) {
        if ($request->user()->id != $repository->user_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('repositories.edit', compact('repository'));
    }

    public function create() {
        return view('repositories.create');
    }
    public function store(RepositoryRequest $request) {
        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function update(RepositoryRequest $request, Repository $repository) {
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
