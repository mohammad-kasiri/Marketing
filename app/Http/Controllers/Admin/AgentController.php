<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Date;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\StoreRequest;
use App\Http\Requests\Agent\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{
    public function index()
    {
        $agents = User::query()->agents()->paginate(User::PAGINATION_LIMIT);
        return view('admin.users.agents.index')->with(['agents' => $agents]);
    }

    public function create()
    {
        return view('admin.users.agents.create');
    }

    public function store(StoreRequest $request)
    {
        $user = User::query()->create(
            array_merge($this->agentInputs($request),
                [
                    'mobile' => $request->validated('mobile'),
                    'password' => Hash::make($request->validated('password')),
                ]
            )
        );
        $user->setAvatar();
        Session::flash('message', 'بازاریاب جدید با موفقیت اضافه شد.');
        return redirect()->route('admin.agent.index');
    }

    public function show(User $agent)
    {
        $invoices = $agent->invoice()->latest()->take(10)->get();



        return view('admin.users.agents.show')
            ->with(['agent'   => $agent])
            ->with(['invoices' => $invoices]);
    }

    public function edit(User $agent)
    {
        return view('admin.users.agents.edit')->with(['agent' => $agent]);
    }

    public function update(UpdateRequest $request, User $agent)
    {
        $agent->update($this->agentInputs($request));
        $agent->setAvatar();
        Session::flash('message', 'تغییرات با موفقیت انجام شد');
        return redirect()->route('admin.agent.show', $agent->id)->with(['agent' => $agent]);
    }

    private function agentInputs($request)
    {
        return [
            'first_name'   => $request->validated('first_name'),
            'last_name'    => $request->validated('last_name'),
            'gender'       => $request->validated('gender'),
            'email'        => $request->validated('email'),
            'percentage'   => $request->validated('percentage'),
            'sheba_number' => $request->validated('sheba_number'),
            'is_active'    => $request->validated('is_active'),
        ];
    }
}
