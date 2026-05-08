<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ReviewController extends Controller
{
    public function allReview(){
        $review = Review::latest()->get();
        return view('admin.backend.review.all_review', compact('review'));
    } // End Method

    public function addReview(){
        return view('admin.backend.review.add_review');
    } // End Method

    public function storeReview(Request $request){
        if($request->file('image')){
            $image =$request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(60,60)->save(public_path('upload/review/'.$name_gen));
            $save_url = 'upload/review/'.$name_gen;

            Review::create([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url,
            ]);
        }
        $notification = array(
            'message' => 'Review Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.review')->with($notification);
    } // End Method

    public function editReview($id){
        $review = Review::findOrFail($id);
        return view('admin.backend.review.edit_review', compact('review'));
    } // End Method

    public function updateReview(Request $request, $id){
        $review = Review::findOrFail($id);
        if($request->file('image')){
            $image =$request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(60,60)->save(public_path('upload/review/'.$name_gen));
            $save_url = 'upload/review/'.$name_gen;

            Review::findOrFail($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url,
            ]);
        } else {
            Review::findOrFail($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
            ]);
        }
        $notification = array(
            'message' => 'Review Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.review')->with($notification);
    } // End Method

    public function deleteReview($id){
        $review = Review::findOrFail($id);
        $img = $review->image;
        unlink($img);
        Review::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Review Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.review')->with($notification);
    } // End Method
    
}
