@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
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
                                    id="slug">
                                <label for="slug">Slug</label>
                                <input 
                                    type="slug" 
                                    name="slug" 
                                    title="Slug" 
                                    class="form-control" 
                                    placeholder="Nhập vào dữ liệu..." 
                                    id="convert_slug"
                                >
                                <label for="description">Mô tả</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Nhập vào dữ liệu..." id="description"></textarea>
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
                                <label>Quốc gia</label>
                                <select name="country_id" id="country_id" class="form-control" value="{{isset($movie) ? $movie->country: ''}}">
                                    @foreach($country as $countryId => $countryTitle)
                                        <option value="{{$countryId}}">{{$countryTitle}}</option>
                                    @endforeach
                                </select>
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
                                <input type="text" value="{{isset($movie) ? $movie->title : ''}} " onkeyup="ChangeToSlug()" name="title" class="form-control" placeholder="Nhập vào dữ liệu..." id="slug">
                                <label for="slug">Slug</label>
                                <input 
                                    type="slug" 
                                    name="slug" 
                                    title="Slug" 
                                    class="form-control" 
                                    placeholder="Nhập vào dữ liệu..." 
                                    id="convert_slug"
                                >                                              
                                <label for="description">Mô tả</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Nhập vào dữ liệu..." id="description">{{ $movie->description }}</textarea>
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
                                <label>Quốc gia</label>
                                <select name="country_id" id="country_id" class="form-control" value="{{isset($movie) ? $movie->country: ''}}">
                                    @foreach($country as $countryId => $countryTitle)
                                        <option value="{{ $countryId }}" {{ isset($movie) && $movie->country_id == $countryId ? 'selected' : '' }}>{{ $countryTitle }}</option>
                                    @endforeach
                                </select>
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

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Slug</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Quốc gia</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $cate)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $cate->title }}</td>
                <td><img src="{{asset('uploads/movie/'.$cate->image)}}" width="150" height="200"></td>
                <td>{{ $cate->description }}</td>
                <td>{{ $cate->slug }}</td>
                <td>
                    {{ $cate->status ? 'Hiển thị' : 'Không hiển thị' }}
                </td>
                <td>{{ $cate->category->title }}</td>
                <td>{{ $cate->genre->title }}</td>
                <td>{{ $cate->country->title }}</td>

                <td>
                    <!-- Nút Xóa -->
                    <form id="delete-form-{{ $cate->id }}" action="{{ route('movie.destroy', $cate) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $cate->id }}">Xóa</button>
                    </form>

                    <!-- Nút Sửa -->
                    <a href="{{ route('movie.edit', $cate->id) }}">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                </td>
            </tr>

            <!-- Modal Xóa -->
            <div class="modal fade" id="confirmDeleteModal{{ $cate->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $cate->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $cate->id }}">Xác nhận xóa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa dữ liệu này không?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" form="delete-form-{{ $cate->id }}" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
