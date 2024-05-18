@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('movie.index')}}" class="btn btn-primary">Liệt kê phim</a>
                <div class="card-header">Quản Lý PHIM</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($movie))
                        <!-- Form Thêm Mới -->
                        <form action="{{ route('movie.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input 
                                    type="text" 
                                    value="{{isset($movie) ? $movie->title: ''}}" 
                                    onkeyup="ChangeToSlug()" 
                                    name="title" 
                                    class="form-control" 
                                    placeholder="Nhập vào dữ liệu..." 
                                    id="slug"
                                    required>
                                    <label>Tên tiếng anh</label>
                                    <input 
                                        type="text" 
                                        value="{{isset($movie) ? $movie->name_eng: ''}}" 
                                        name="name_eng" 
                                        class="form-control" 
                                        placeholder="Nhập vào dữ liệu..." 
                                        id="name_eng"
                                        required>
                                <label for="slug">Slug</label>
                                <input 
                                    type="slug" 
                                    name="slug" 
                                    title="Slug" 
                                    class="form-control" 
                                    placeholder="Nhập vào dữ liệu..." 
                                    id="convert_slug"
                                    required
                                >
                                <label for="description">Mô tả</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Nhập vào dữ liệu..." id="description" required></textarea>
                                <label for="status">Trạng thái:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Không hiển thị</option>
                                </select>
                                <label>Danh mục</label>
                                <select name="category_id" id="category_id" class="form-control" value="{{isset($movie) ? $movie->category: ''}}">
                                    @foreach($category as $categoryId => $categoryTitle)
                                        <option value="{{$categoryId}}">{{$categoryTitle}}</option>
                                    @endforeach
                                </select>
                                <label>Thể loại</label>
                                <select name="genre_id" id="genre_id" class="form-control" value="{{isset($movie) ? $movie->genre: ''}}">
                                    @foreach($genre as $genreId => $genreTitle)
                                        <option value="{{$genreId}}">{{$genreTitle}}</option>
                                    @endforeach
                                </select>
                                <label>Phim Hot</label>
                                <select name="phim_hot" id="phim_hot" class="form-control" value="{{isset($movie) ? $movie->phim_hot: ''}}">
                                    <option value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <label for="resolution">Định dạng</label>
                                <select name="resolution" id="resolution" class="form-control" value="{{isset($movie) ? $movie->resolution: ''}}">
                                    <option value="0">HD</option>
                                    <option value="1">SD</option>
                                    <option value="2">HDCam</option>
                                    <option value="3">Cam</option>
                                    <option value="4">FulHD</option>
                                </select>
                                <label for="subtitle">Phụ đề</label>
                                <select name="subtitle" id="subtitle" class="form-control" value="{{isset($movie) ? $movie->subtitle: ''}}">
                                    <option value="0">VietSub</option>
                                    <option value="1">Thuyết Minh</option>
                                    <option value="2">Phụ đề</option>
                                </select>
                                <label>Quốc gia</label>
                                <select name="country_id" id="country_id" class="form-control" value="{{isset($movie) ? $movie->country: ''}}">
                                    @foreach($country as $countryId => $countryTitle)
                                        <option value="{{$countryId}}">{{$countryTitle}}</option>
                                    @endforeach
                                </select>
                                <label>Thời lượng</label>
                                <input type="text"  name="title" class="form-control" placeholder="Nhập vào dữ liệu..." required>
                                <label>Hình ảnh minh họa</label>
                                <input type="file" name="image" id="image" placeholder="hình ảnh" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm dữ liệu</button>
                        </form>
                    @else
                        <!-- Form Sửa -->
                        <form action="{{ route('movie.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" value="{{isset($movie) ? $movie->title : ''}} " onkeyup="ChangeToSlug()" name="title" class="form-control" placeholder="Nhập vào dữ liệu..." id="slug" required>
                                <label for="title">Tên tiếng anh</label>
                                <input type="text" value="{{isset($movie) ? $movie->name_eng : ''}} "  name="name_eng" class="form-control" placeholder="Nhập vào dữ liệu..." id="name_eng" required>
                                <label for="slug">Slug</label>
                                <input 
                                    type="slug" 
                                    name="slug" 
                                    title="Slug" 
                                    class="form-control" 
                                    placeholder="Nhập vào dữ liệu..." 
                                    id="convert_slug"
                                    required
                                >                                              
                                <label for="description">Mô tả</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Nhập vào dữ liệu..." id="description" required>{{ $movie->description }}</textarea>
                                <label for="status">Trạng thái:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $movie->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ $movie->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
                                </select>
                                <label>Danh mục</label>
                                <select name="category_id" id="category_id" class="form-control" value="{{isset($movie) ? $movie->category: ''}}">
                                    @foreach($category as $categoryId => $categoryTitle)
                                        <option value="{{ $categoryId }}" {{ isset($movie) && $movie->category_id == $categoryId ? 'selected' : '' }}>{{ $categoryTitle }}</option>
                                    @endforeach
                                </select>
                                <label>Thể loại</label>
                                <select name="genre_id" id="genre_id" class="form-control" value="{{isset($movie) ? $movie->genre: ''}}">
                                    @foreach($genre as $genreId => $genreTitle)
                                        <option value="{{ $genreId }}" {{ isset($movie) && $movie->genre_id == $genreId ? 'selected' : '' }}>{{ $genreTitle }}</option>
                                    @endforeach
                                </select>
                                <label>Phim HOT</label>
                                <select name="phim_hot" id="phim_hot" class="form-control">
                                    <option value="1" {{ $movie->phim_hot == 1 ? 'selected' : '' }}>Có</option>
                                    <option value="0" {{ $movie->phim_hot == 0 ? 'selected' : '' }}>Không</option>
                                </select>
                                <label>Định dạng</label>
                                <select name="resolution" id="resolution" class="form-control">
                                    <option value="0" {{ $movie->resolution == 0 ? 'selected' : '' }}>HD</option>
                                    <option value="1" {{ $movie->resolution == 1 ? 'selected' : '' }}>SD</option>
                                    <option value="2" {{ $movie->resolution == 2 ? 'selected' : '' }}>HDCam</option>
                                    <option value="3" {{ $movie->resolution == 3 ? 'selected' : '' }}>Cam</option>
                                    <option value="4" {{ $movie->resolution == 4 ? 'selected' : '' }}>FullHD</option>
                                </select>
                                <label>Định dạng</label>
                                <select name="subtitle" id="subtitle" class="form-control">
                                    <option value="0" {{ $movie->subtitle == 0 ? 'selected' : '' }}>VietSub</option>
                                    <option value="1" {{ $movie->subtitle == 1 ? 'selected' : '' }}>Thuyết minh</option>
                                    <option value="2" {{ $movie->subtitle == 2 ? 'selected' : '' }}>Phụ đề</option>
                                </select>
                                <label>Quốc gia</label>
                                <select name="country_id" id="country_id" class="form-control" value="{{isset($movie) ? $movie->country: ''}}">
                                    @foreach($country as $countryId => $countryTitle)
                                        <option value="{{ $countryId }}" {{ isset($movie) && $movie->country_id == $countryId ? 'selected' : '' }}>{{ $countryTitle }}</option>
                                    @endforeach
                                </select>
                                <label for="time">Thời lượng</label>
                                <input type="text" value="{{isset($movie) ? $movie->time : ''}} " name="time" class="form-control" placeholder="Nhập vào dữ liệu..." required>
                                <label>Hình ảnh</label>
                                @if($movie)
                                <input type="file" name="image" id="image" placeholder="hình ảnh" class="form-control">
                                    <img src="{{asset('uploads/movie/'.$movie->image)}}" sizes="40%">
                                @endif
                            </div>
                            @if(!isset($movie))
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            @else
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                            @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection
