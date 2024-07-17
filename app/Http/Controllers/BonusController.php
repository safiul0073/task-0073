<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index(Request $request)
    {
        $bonuses = Bonus::where('sender_id', auth()->user()->id)
            ->with('receiver:id,name')
            ->paginate();

        return view('dashboard.gift.bonuses', compact('bonuses'));
    }

    public function create()
    {
        return view('dashboard.gift.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = User::find(auth()->id());

        $my_referrals = $sender->referrals;

        // the given amount is have to sender balance

        if ($sender->balance < $request->amount) {
            return back()->with('error', 'Your balance is not enough');
        }

        $sender->balance = $sender->balance - $request->amount;

        $per_person_amount = (int) $request->amount / count($my_referrals);

        $this->sendGift($sender, $per_person_amount, $my_referrals);

        $sender->save();

        return redirect()->back()->with('success', 'Successfully sent');
    }

    private function sendGift($sender, $amount, $my_referrals)
    {
        foreach ($my_referrals as $referral) {
            $referral->balance = $referral->balance + $amount;
            $referral->save();

            $sender->bonuses()->create([
                'receiver_id' => $referral->id,
                'amount' => $amount,
            ]);

            if (count($referral->referrals)) {
                $this->sendGift($sender, $referral->amount, $referral->referrals);
            }
        }
    }
}
