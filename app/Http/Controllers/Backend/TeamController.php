<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TeamController extends Controller
{
    public function allTeam()
    {
        $teams = Team::latest()->get();

        return view('admin.backend.team.all_team', compact('teams'));
    }

    public function addTeam()
    {
        return view('admin.backend.team.add_team');
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = new Team;
        $team->name = $request->name;
        $team->position = $request->position;
        $team->email = $request->email;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('upload/team/'.$filename);

            // Create the directory if it doesn't exist
            if (! file_exists(public_path('upload/team'))) {
                mkdir(public_path('upload/team'), 0755, true);
            }

            // Resize and save the image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image);
            $image->resize(306, 400);
            $image->save($path);

            $team->image = 'upload/team/'.$filename;
        }

        $team->save();

        return redirect()->route('all.team')->with('success', 'Team member added successfully.');
    }

    public function editTeam($id)
    {
        $team = Team::findOrFail($id);

        return view('admin.backend.team.edit_team', compact('team'));
    }

    public function updateTeam(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = Team::findOrFail($id);
        $team->name = $request->name;
        $team->email = $request->email;
        $team->position = $request->position;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($team->image && file_exists(public_path($team->image))) {
                unlink(public_path($team->image));
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('upload/team/'.$filename);

            // Create the directory if it doesn't exist
            if (! file_exists(public_path('upload/team'))) {
                mkdir(public_path('upload/team'), 0755, true);
            }

            // Resize and save the image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image);
            $image->resize(306, 400);
            $image->save($path);

            $team->image = 'upload/team/'.$filename;
        }

        $team->save();

        return redirect()->route('all.team')->with('success', 'Team member updated successfully.');
    }

    public function deleteTeam($id)
    {
        $team = Team::findOrFail($id);

        // Delete image if exists
        if ($team->image && file_exists(public_path($team->image))) {
            unlink(public_path($team->image));
        }

        $team->delete();

        return redirect()
            ->route('all.team')->with('success', 'Team member deleted successfully.');
    }
}
