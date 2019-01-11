<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth');

        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $videos = $this->repository->videosFromSubscriptions($request->user());

        return view('home', compact('videos'));
    }
}
