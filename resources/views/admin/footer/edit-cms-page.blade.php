<style>
    .form-control-feedback {
      top: 9px !important;
    }
</style>
@extends('layouts.adminLayout.backendLayout')
@section('content')
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/adapters/jquery.js')!!}"></script>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>CMS Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/cms-pages') }}">CMS Pages</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Edit CMS Page
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="edit-cms-form" class="form-horizontal" method="POST" action="{{ url('admin/edit-cms-page/'.$details['id']) }}">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Title</label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="Enter Title" class="form-control" name="title" value="{{ $details['title'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description">{{ $details['description'] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right1 text-center">
                            <button class="btn green" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document). ready(function(){
    $('#edit-cms-form').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        icon: 
        {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        err: 
        {
            container: 'popover'
        },
        fields: 
        {
            title: 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Title is required and cannot be empty'
                    }
                }
            },
            description: 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Description is required and cannot be empty'
                    },
                    callback: 
                    {
                        message: 'Description must be less than 100000 characters long',
                        callback: function(value, validator, $field) 
                        {
                            if (value === '') 
                            {
                                return true;
                            }
                            var div  = $('<div/>').html(value).get(0),
                                text = div.textContent || div.innerText;
                            return text.length <= 100000;
                        }
                    }
                }
            }
        }
    })
     $('#edit-cms-form').find('[name="description"]')
            .ckeditor()
            .editor
            .on('change', function() {
                $('#edit-cms-form').formValidation('revalidateField', 'description');
                $('#edit-cms-form').formValidation('revalidateField', 'title');
        });
});
</script>
@endsection