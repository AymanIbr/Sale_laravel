@extends('admin.layout.master')
@section('HomeName','الضبط العام')
@section('contentheder','الخزن')
@section('contentheaderlink')
<a href="{{ route('treasuries.index') }}">الخزن</a>
@endsection
@section('contenthedareactirv','عرض')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات الخزن </h3>
          <a href="{{ route('treasuries.create') }}" class="btn btn-sm btn-success">اضافة جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="col-md-4">
                <input type="text" id="search_by_text" placeholder="بحث الاسم" class="form-control">
            </div>
            <br>
            @if (@isset($data) && !@empty($data))
            @php
                $i = 1 ;
            @endphp
            <div id="ajax_response_serarchDiv">
                <table id="example2" class="table table-bordered table-hover">
                    {{-- الكلاس موجود في ملف الcss  --}}
                    <thead class="custom_thead">
                        <th>مسلسل</th>
                        <th>اسم الخزنة</th>
                        <th>هل رئيسية</th>
                        <th>اخر ايصال صرف</th>
                        <th>حالة التفعيل</th>
                        <th>اخر ايصال تحصيل</th>
                        <th></th>
                        {{-- <th>تاريخ الاضافة</th>
                        <th>تاريخ التحديث</th> --}}
                    </thead>
                    <tbody>
                        @foreach ($data as $info )
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                {{ $info->name }}
                            </td>
                            <td>
                                @if ($info->is_master == 1)
                                رئيسية
                                @else
                                فرعية
                                @endif
                            </td>
                            <td>
                                {{ $info->last_isal_exhcange }}
                            </td>
                            <td>
                                @if ($info->active == 1) مفعل @else معطل @endif
                            </td>
                            <td>
                                {{ $info->last_isal_collect }}
                            </td>
                            <td>
                                <a href = "{{ route('treasuries.edit',$info->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                <a data-id="{{ $info->id }}" class="btn btn-sm btn-info">المزيد</a>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </tbody>
                          </table>
                        <br>
                        {{ $data->links() }}
            </div>
            @else
            <div class="alert alert-danger">
                عفوا لا توجد بيانات لعرضها
            </div>
            @endif
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>

@endsection
