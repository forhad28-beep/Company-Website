<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Clarifi;
use App\Models\Connect;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Financial;
use App\Models\Usability;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HomeController extends Controller
{
    public function allFeature()
    {
        $feature = Feature::latest()->get();

        return view('admin.backend.feature.all_feature', compact('feature'));
    } // End Method

    public function addFeature()
    {
        return view('admin.backend.feature.add_feature');
    } // End Method

    public function storeFeature(Request $request)
    {
        Feature::create([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => 'Feature Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    } // End Method

    public function editFeature($id)
    {
        $feature = Feature::findOrFail($id);

        return view('admin.backend.feature.edit_feature', compact('feature'));
    } // End Method

    public function updateFeature(Request $request, $id)
    {
        Feature::findOrFail($id)->update([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => 'Feature Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    } // End Method

    public function deleteFeature($id)
    {
        Feature::findOrFail($id)->delete();

        $notification = [
            'message' => 'Feature Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    } // End Method

    public function getClarifies()
    {
        $clarifi = Clarifi::findOrFail(1);

        return view('admin.backend.clarify.get_clarifies', compact('clarifi'));
    } // End Method

    public function updateClarifies(Request $request)
    {
        $clarifi_id = $request->id;

        $clarifi = Clarifi::findOrFail($clarifi_id);

        // New Image Upload
        if ($request->file('image')) {
            // Delete old image
            if (file_exists(public_path($clarifi->image))) {
                unlink(public_path($clarifi->image));
            }
            // Intervention Image
            $image = $request->file('image');
            $manager = new ImageManager(new Driver);
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(302, 618)
                ->save(public_path('upload/clarifies/'.$name_gen));
            $save_url = 'upload/clarifies/'.$name_gen;
            $clarifi->image = $save_url;
        }

        $clarifi->title = $request->title;
        $clarifi->description = $request->description;
        $clarifi->save();
        $notification = [
            'message' => 'Clarifies Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('get.clarifies')->with($notification);
    }

    public function getFinancials()
    {
        $financial = Financial::findOrFail(1);

        return view('admin.backend.financial.get_financials', compact('financial'));
    } // End Method

    public function updateFinancials(Request $request)
    {
        $financial_id = $request->id;

        $financial = Financial::findOrFail($financial_id);

        // New Image Upload
        if ($request->file('image')) {
            // Delete old image
            if (file_exists(public_path($financial->image))) {
                unlink(public_path($financial->image));
            }
            // Intervention Image
            $image = $request->file('image');
            $manager = new ImageManager(new Driver);
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(307, 619)
                ->save(public_path('upload/financials/'.$name_gen));
            $save_url = 'upload/financials/'.$name_gen;
            $financial->image = $save_url;
        }

        $financial->title = $request->title;
        $financial->description = $request->description;
        $financial->subDesOne = $request->subDesOne;
        $financial->subDesTwo = $request->subDesTwo;
        $financial->save();
        $notification = [
            'message' => 'Financials Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('get.financials')->with($notification);
    }

    public function getUsabilities()
    {
        $usability = Usability::findOrFail(1);

        return view('admin.backend.usability.get_usabilities', compact('usability'));
    } // End Method

    public function updateUsabilities(Request $request)
    {
        $usability_id = $request->id;

        $usability = Usability::findOrFail($usability_id);

        // New Image Upload
        if ($request->file('image')) {
            // Delete old image
            if (file_exists(public_path($usability->image))) {
                unlink(public_path($usability->image));
            }
            // Intervention Image
            $image = $request->file('image');
            $manager = new ImageManager(new Driver);
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(560, 400)
                ->save(public_path('upload/usabilities/'.$name_gen));
            $save_url = 'upload/usabilities/'.$name_gen;
            $usability->image = $save_url;
        }

        $usability->title = $request->title;
        $usability->description = $request->description;
        $usability->youtube = $request->youtube;
        $usability->link = $request->link;
        $usability->save();
        $notification = [
            'message' => 'Usabilities Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('get.usabilities')->with($notification);
    }

    public function allConnect()
    {
        $connect = Connect::latest()->get();

        return view('admin.backend.connect.all_connect', compact('connect'));
    } // End Method

    public function addConnect()
    {
        return view('admin.backend.connect.add_connect');
    } // End Method

    public function storeConnect(Request $request)
    {
        Connect::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => 'Connect Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.connect')->with($notification);
    } // End Method

    public function editConnect($id)
    {
        $connect = Connect::findOrFail($id);

        return view('admin.backend.connect.edit_connect', compact('connect'));
    } // End Method

    public function updateConnect(Request $request, $id)
    {
        Connect::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => 'Connect Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.connect')->with($notification);
    } // End Method

    public function deleteConnect($id)
    {
        Connect::findOrFail($id)->delete();

        $notification = [
            'message' => 'Connect Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.connect')->with($notification);
    } // End Method

    public function allFaq()
    {
        $faq = Faq::latest()->get();

        return view('admin.backend.faq.all_faq', compact('faq'));
    }

    public function addFaq()
    {
        return view('admin.backend.faq.add_faq');
    } // End Method

    public function storeFaq(Request $request)
    {
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        $notification = [
            'message' => 'FAQ Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.faqs')->with($notification);
    } // End Method

    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);

        return view('admin.backend.faq.edit_faq', compact('faq'));
    } // End Method

    public function updateFaq(Request $request, $id)
    {
        Faq::findOrFail($id)->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        $notification = [
            'message' => 'FAQ Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.faqs')->with($notification);
    } // End Method

    public function deleteFaq($id)
    {
        Faq::findOrFail($id)->delete();

        $notification = [
            'message' => 'FAQ Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.faqs')->with($notification);
    } // End Method

    public function updateApp(Request $request, $id)
    {
        $apps = App::findOrFail($id);

        $apps->update($request->only(['title', 'description']));

        return response()->json(['success' => true, 'message' => 'Updated successfully']);
    }

    public function updateAppImage(Request $request, $id)
    {
        $apps = App::findOrFail($id);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver);
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(306, 481)->save(public_path('upload/apps/'.$name_gen));
            $save_url = 'upload/apps/'.$name_gen;

            // Delete old image
            if (file_exists(public_path($apps->image))) {
                unlink(public_path($apps->image));
            }
            
            $apps->update(['image' => $save_url]);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'image_url' => asset($save_url),
            ]);
        }
        return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
    }
}
