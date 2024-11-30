<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RepositoryController extends Controller {


    public function index() {
        return view('repositories.index', ['repositories' => auth()->user()->repositories]);
    }

    public function show(Repository $repository) {
        Gate::authorize('pass', $repository);
        return view('repositories.show', compact('repository'));
    }

    public function edit(Repository $repository) {
        Gate::authorize('pass', $repository);
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
        Gate::authorize('pass', $repository);
        $repository->update($request->all());
        return redirect()->route('repositories.edit', $repository);
    }

    public function destroy(Repository $repository) {
        Gate::authorize('pass', $repository);
        $repository->delete();
        return redirect()->route('repositories.index');
    }
}
