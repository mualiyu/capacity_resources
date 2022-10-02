<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    public function get_all(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $resources = Resource::all();

                if (count($resources) > 0) {
                        # code...
                        $res = [
                            'status' => true,
                            'data' => $resources,
                        ];
                        return response()->json($res);
                   
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'NO resource found in the system',
                    ];
                    return response()->json($res);
                }

            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }



    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'title' => ['required'],
            'area' => ['required'],
            'level' => ['required'],
            'date' => ['required'],
            'lang' => ['required'],
            'type' => ['required'],
            'link' => ['required'],
            'image' => "image|mimes:jpeg,jpg,png,gif|max:9000|required",
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {
                $image = $request->file('image');

                if ($request->hasFile("image")) {
                    $imageNameWExt = $request->file("image")->getClientOriginalName();
                    $imageName = pathinfo($imageNameWExt, PATHINFO_FILENAME);
                    $imageExt = $request->file("image")->getClientOriginalExtension();

                    $imageNameToStore =  $imageName. "_" . time() . "." . $imageExt;

                    $image->move("image", $imageNameWExt);
                    // $request->file("image")->storeAs("public/package/delivery", $imageNameToStore);
                } else {
                    $res = [
                        'status' => false,
                        'data' => "Image uploaded is invalid."
                    ];
                    return response()->json($res);
                }

                $imageNameToStore = url("/image/$imageNameWExt");

                $resource = Resource::create([
                        'title' => $request->title,
                        'area' => $request->area,
                        'level' => $request->level,
                        'date' => $request->date,
                        'lang' => $request->lang,
                        'type' => $request->type,
                        'link' => $request->link,
                        'image' => $imageNameToStore,
                    ]);

                if ($resource) {
                    # code...
                    $res = [
                        'status' => true,
                        'data' => $resource,
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Failed to create Resource, Try again',
                    ];
                    return response()->json($res);
                }

            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }


    public function get_by_id(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $resources = Resource::where('id', $request->id)->get();

                if (count($resources) > 0) {
                        # code...
                        $res = [
                            'status' => true,
                            'data' => $resources[0],
                        ];
                        return response()->json($res);
                   
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'NO resource found in the system',
                    ];
                    return response()->json($res);
                }

            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }
}
