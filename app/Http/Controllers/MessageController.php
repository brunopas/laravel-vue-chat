<?php

namespace App\Http\Controllers;

use App\Events\Chat\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listMessages(User $user)
    {
        $userFrom = auth()->user()->id;
        $userTo = $user->id;

        $messages = Message::where(function ($query) use ($userFrom, $userTo) {
            $query->where([
                'from' => $userFrom,
                'to' => $userTo
            ]);
        })
            ->orWhere(function ($query) use ($userFrom, $userTo) {
                $query->where([
                    'from' => $userTo,
                    'to' => $userFrom
                ]);
            })->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages,
        ], Response::HTTP_OK);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->from = auth()->user()->id;
        $message->to = $request->to;
        $message->content = filter_var($request->content, FILTER_SANITIZE_STRIPPED);
        $message->save();

        Event::dispatch(new SendMessage($message, $request->to));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
