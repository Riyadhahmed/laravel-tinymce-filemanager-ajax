<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use View;

class BlogController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */


   public function home()
   {
      return view('home');
   }

   public function index(Request $request)
   {
      $blogs = Blog::orderby('created_at', 'desc')->paginate(5);
      if ($request->ajax()) {
         return view('blogPag', compact('blogs'));
      }
      return view('blog', compact('blogs'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('create');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      if ($request->ajax()) {

         $rules = [
           'title' => 'required',
           'photo' => 'image|max:2024|mimes:jpeg,jpg,gif,png'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $upload_ok = 1;
            $file_path = 'assets/images/book_image/default.jpg';

            if ($request->hasFile('photo')) {

               if (Input::file('photo')->isValid()) {
                  $destinationPath = 'assets/images/book_image'; // upload path
                  $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                  $fileName = time() . '.' . $extension; // renameing image
                  $file_path = 'assets/images/book_image/' . $fileName;
                  Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                  $upload_ok = 1;

               } else {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                  ]);
               }
            }


            if ($upload_ok == 0) {
               return response()->json([
                 'type' => 'error',
                 'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
               ]);
            } else {
               $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'))));
               $blog = new Blog();
               $blog->title = $request->input('title');
               $blog->slug = $slug;
               $blog->description = $request->input('description');
               $blog->category = $request->input('category');
               $blog->status = 1;
               $blog->file_path = $file_path;
               $blog->save(); //
               return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
            }

         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Blog $blog
    * @return \Illuminate\Http\Response
    */
   public function show(Blog $blog)
   {
      return view('view', compact('blog'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Blog $blog
    * @return \Illuminate\Http\Response
    */
   public function edit(Blog $blog)
   {
      return view('edit', compact('blog'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \App\Models\Blog $blog
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Blog $blog)
   {
      if ($request->ajax()) {

         $rules = [
           'title' => 'required',
           'photo' => 'image|max:2024|mimes:jpeg,jpg,gif,png'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $upload_ok = 1;
            $file_path = 'assets/images/book_image/default.jpg';

            if ($request->hasFile('photo')) {

               if (Input::file('photo')->isValid()) {
                  $destinationPath = 'assets/images/book_image'; // upload path
                  $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                  $fileName = time() . '.' . $extension; // renameing image
                  $file_path = 'assets/images/book_image/' . $fileName;
                  Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                  $upload_ok = 1;

               } else {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                  ]);
               }
            }


            if ($upload_ok == 0) {
               return response()->json([
                 'type' => 'error',
                 'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
               ]);
            } else {
               $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'))));
               $blog->title = $request->input('title');
               $blog->slug = $slug;
               $blog->description = $request->input('description');
               $blog->category = $request->input('category');
               $blog->status = 1;
               $blog->file_path = $file_path;
               $blog->save(); //
               return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
            }

         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Blog $blog
    * @return \Illuminate\Http\Response
    */

   public function destroy(Request $request, Blog $blog)
   {
      if ($request->ajax()) {
         $blog->delete();
         return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
