<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static $default = 'default.png';
    static $diskName = 'LeiloArte';

    static $systemTypes = [
        'users' => ['png', 'jpg', 'jpeg', 'gif'],
        'auctions' => ['png', 'jpg', 'jpeg', 'gif'],
    ];

    private static function isValidType (String $type) {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset (String $type) {
        return asset($type . '/' . self::$default);
    }

    private static function isValidExtension(String $type, String $extension) {
        $allowedExtensions = self::$systemTypes[$type];
        return in_array(strtolower($extension), $allowedExtensions);
    }


    private static function getFileName (String $type, int $id) {
        
        $fileName = null;
        switch($type) {
            case 'users':
                $fileName = User::find($id)->img;
                break;
            case 'auctions':
                $fileName = Auction::find($id)->img;
                break;
            }
    
        return $fileName;
    }

    public static function delete (String $type, int $id) {
        $fileName = self::getFileName($type, $id);

        if ($fileName && $fileName != ($type . '/' . self::$default)) {
            Storage::disk(self::$diskName)->delete($fileName);
        }

        switch ($type) {
            case 'users':
                User::find($id)->img = null;
                User::find($id)->save();
                break;
            case 'auctions':
                Auction::find($id)->img = null;
                Auction::find($id)->save();
                break;
            default:
                break;
        }
    }

    public static function get(String $type, int $userId) {

        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }
    
        // Validation: file exists
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }
    
        // Not found: returns default asset
        return self::defaultAsset($type);
    }

    function upload(Request $request) {

        
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Error: File not found');
        }

        if (!$this->isValidType($request->type)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload type');
        }

        $file = $request->file('file');
        $type = $request->type;
        $id = $request->id;
        $extension = $file->extension();

        if (!$this->isValidExtension($type, $extension)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload extension');
        }
        
        $this->delete($type, $request->id);
        // Hashing
        $fileName = $file->hashName(); // generate a random unique id

        $error = null;

        switch ($type) {
            case 'users':
                $user = User::findorfail($id);
                if ($user) {
                    $user->img = "users/$fileName";
                    $user->save();
                } 

                else {
                    $error = 'Error: User not found';
                }
                break;

            case 'auctions':
                $auction = Auction::findorfail($id);
                if ($auction) {
                    $auction->image = "auctions/$fileName";
                    $auction->save();
                } 

                else {
                    $error = 'Error: Auction not found';
                }
                break;

            default:
                redirect()->back()->with('error', 'Error: Unsupported upload object');

        }

        if ($error) {
            redirect()->back()->with('error', `Error: {$error}`);
        }

        // Save in correct folder and disk
        $request->file->storeAs($type, $fileName, self::$diskName);
        return redirect()->back()->with('success', 'Success: upload completed!');
    }        
}

