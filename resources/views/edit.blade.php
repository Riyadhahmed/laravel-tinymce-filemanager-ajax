@extends('layouts.master')
@section('title', 'Edit')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title"> Edit Blog </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <div id="status"></div>
                                {{method_field('PATCH')}}
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for=""> Title </label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $blog->title }}"
                                           placeholder="" required>
                                    <span id="error_title" class="has-error"></span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for=""> Description </label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                              rows="10"
                                              placeholder="">{{ $blog->description }}</textarea>
                                    <span id="error_description" class="has-error"></span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for=""> Category </label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="{{ $blog->category }}">{{ $blog->category }}</option>
                                        <option value="Notice Board">Notice Board</option>
                                        <option value="Latest News">Latest News</option>
                                        <option value="Job News">Job News</option>
                                    </select>
                                    <span id="error_category" class="has-error"></span>
                                </div>
                                <div class="col-md-8">
                                    <label for="photo">Upload Image</label>
                                    <input id="photo" type="file" name="photo" style="display:none">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a class="btn btn-success"
                                               onclick="$('input[id=photo]').click();">Browse</a>
                                        </div><!-- /btn-group -->
                                        <input type="text" name="SelectedFileName" class="form-control"
                                               id="SelectedFileName"
                                               value="{{ $blog->file_path }}" readonly>
                                    </div>
                                    <div class="clearfix"></div>
                                    <p class="help-block">File must be jpg, jpeg, png. width below 1500px and heigth
                                        700px
                                        and less than 2mb</p>
                                    <script type="text/javascript">
                                        $('input[id=photo]').change(function () {
                                            $('#SelectedFileName').val($(this).val());
                                        });
                                    </script>
                                    <span id="error_photo" class="has-error"></span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success button-submit"
                                            data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "textarea#description",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <script>
        $(document).ready(function () {
            $('#loader').hide();
            $('#edit').validate({// <- attach '.validate()' to your form
                // Rules for form validation
                rules: {
                    title: {
                        required: true
                    },
                    category: {
                        required: true
                    }
                },
                // Messages for form validation
                messages: {
                    name: {
                        required: 'Enter title'
                    }
                },
                submitHandler: function (form) {

                    var myData = new FormData($("#edit")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);

                    $.ajax({
                        url: '/blogs/' + '{{ $blog->id }}',
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#loader').show();
                            $(".button-submit").prop('disabled', false); // disable button
                        },
                        success: function (data) {
                            if (data.type === 'success') {
                                notify_view(data.type, data.message);
                                reload_table();
                                $('#loader').hide();
                                $(".button-submit").prop('disabled', false); // disable button
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('#myModal').modal('hide'); // hide bootstrap modal

                            } else if (data.type === 'error') {
                                if (data.errors) {
                                    $.each(data.errors, function (key, val) {
                                        $('#error_' + key).html(val);
                                    });
                                }
                                $("#status").html(data.message);
                                $('#loader').hide();
                                $(".button-submit").prop('disabled', false); // disable button

                            }
                        }
                    });
                }
                // <- end 'submitHandler' callback
            });                    // <- end '.validate()'

        });
    </script>
@stop