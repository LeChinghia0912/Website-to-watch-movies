<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use Carbon\Carbon;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();
        return view('admin.movie.index', compact('list'));
    }

    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();

        return response()->json(['success' => true]);
    }

    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
        
        return response()->json(['success' => true]);   
    }

    public function filter_default(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', 0)->orderBy('ngaycapnhat', 'desc')->take(20)->get();
        $output = '';
        foreach ($movie as $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'FullHD';
            } else {
                $text = 'Trailer';
            }
            
            $output .= '<div class="item">
                    <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                        <div class="item-link">
                            <img src="' . url('uploads/movie/' . $mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />
                            <span class="is_trailer">' . $text . '</span>
                        </div>
                        <p class="title">' . $mov->title . '</p>
                    </a>
                    <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                    <div style="float: left;">
                        <span class="user-rate-image post-large-rate stars-large-vang"
                            style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                        </span>
                    </div>
                </div>';
        }
        echo $output;
    }

    public function filter_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', $data['value'])->orderBy('ngaycapnhat', 'desc')->take(20)->get();
        $output = '';
        foreach ($movie as $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } else{
                $text = 'FullHD';
            } 
            $output .= '<div class="item">
                    <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                        <div class="item-link">
                            <img src="' . url('uploads/movie/' . $mov->image) . '"
                                class="lazy post-thumb" alt="' . $mov->title . '"
                                title="' . $mov->title . '" />
                            <span class="is_trailer">' . $text . '</span>
                        </div>
                        <p class="title">' . $mov->title . '</p>
                    </a>
                    <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                    <div style="float: left;">
                        <span class="user-rate-image post-large-rate stars-large-vang"
                            style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                        </span>
                    </div>
                </div>';
        }
        echo $output;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $phim_hot = Movie::pluck('title', 'id');
        return view('admin.movie.form', compact('category', 'genre', 'country', 'phim_hot'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->tags = $data['tags'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->time = $data['time'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        //thêm hình ảnh
        $get_image = $request->file('image');


        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        //thêm hình ảnh
        $get_image = $request->file('image');


        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $list = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();
        $movie = Movie::find($id);
        return view('admin.movie.form', compact('category', 'genre', 'country', 'list', 'movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $movie =  Movie::find($id);
        $movie->title = $data['title'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->tags = $data['tags'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->time = $data['time'];
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
        
        //thêm hình ảnh
        $get_image = $request->file('image');

        if($get_image){
            if(file_exists('uploads/movie/' .$movie->image)){
                unlink('uploads/movie/' .$movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        if(file_exists('uploads/movie/' .$movie->image)){
            unlink('uploads/movie/' .$movie->image);
        }
        $movie->delete();
        return redirect()->back();
    }
}
