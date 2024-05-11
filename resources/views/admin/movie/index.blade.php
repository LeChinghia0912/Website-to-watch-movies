@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{route('movie.create')}}" class="btn btn-primary">Quản lý phim</a>

    <table class="table" id="tablephim">
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
                <th scope="col">Phim HOT</th>
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
                <td>
                    {{ $cate->phim_hot ? 'Có' : 'Không' }}
                    {{-- @if ($cate->phim_hot == 0)
                        Có
                    @else
                        Không
                    @endif --}}
                </td>
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
