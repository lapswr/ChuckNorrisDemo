<?php

namespace App\Http\Controllers;

use App\Mail\Joke;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\Emails;

class IndexController extends Controller
{
    /**
     * load the form so user can input the emails
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emailsForm(Request $request)
    {
        return view('index.emailsForm');
    }

    /**
     * Take a list of emails validate them and present them
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function emailsListing(Request $request)
    {
        // Email Validation
        $validator = Validator::make($request->all(), [
            'emails' => ['required', new Emails]
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        // Split the comma separated email string to a Collection
        // and then map the collection to groups keys based on the domain name and in the end sort the keys (Domains1)
        $emailsCollection = collect(explode(',',$request->get('emails','')))
            ->filter()
            ->mapToGroups(function ($email)
            {
                if(!empty($email)) {
                    $splitedEmail = explode('@', trim($email));
                    return [$splitedEmail[1] => ['email' => trim($email), 'name' => $splitedEmail[0], 'domain' => $splitedEmail[1]]];
                }
            })
            ->sortKeys();

        // Sort the sub-collection of every domain based on name of the email
        $emailsCollection->transform(function ($emails, $domain) {
            return $emails->sortBy('name');
        });

        // Remove the grouping based on domains to get only a collection of emails
        // (if we wanted to present the email grouped based on domain name this step can be skipped )
        $emailsCollection = $emailsCollection->flatten(1);

        return view('index.emailsListing', ['emailsCollection' => $emailsCollection]);
    }

    /**
     * Send a Chuck Norris Joke by email to a list of emails or to an email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendEmail(Request $request)
    {
        try {
            // Email Validation
            $validator = Validator::make($request->all(), [
                'email' => ['sometimes', 'email'],
                'emails' => ['sometimes', new Emails]
            ]);

            if ($validator->fails()) {
                throw new \Exception('Email is not valid!');
            }

            $emails = collect([]);
            if($request->has('email')){
                $emails->push($request->email);
            }
            elseif ($request->has('emails'))
            {
                $emails = collect(explode(',', $request->emails));
            }
            if($emails->isEmpty()){
                throw new \Exception('Emails is not valid!');
            }

            $client = new Client();
            $apiResponse = $client->request('GET', 'http://api.icndb.com/jokes/random');

            if ($apiResponse->getStatusCode() == 200)
            {
                $jokeArray = json_decode($apiResponse->getBody(), true);

                if (!empty($jokeArray['value']['joke']))
                {
                    foreach ($emails as $email)
                    {
                        // send joke by email
                        Mail::to($email)->send(new Joke($jokeArray['value']['joke']));
                    }
                    return response()->json(['message' => 'Joke Send Successfully!'], 200);
                }
                else
                {
                    throw new \Exception('Error retrieving a joke' );
                }
            }
            else
            {
                throw new \Exception('Couldn\'t retrieve a joke' );
            }
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
