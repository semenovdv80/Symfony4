/**
 * Created by andrecukerman on 3/2/17.
 */
function toggleSort() {
    if(sort.type == 'asc') sort.type = 'desc';
    else sort.type = 'asc';

    applySort();
}

function applySort() {
    $.cookie("sortCol", sort.col, {
        expires : 10,
        path    : '/'
    });
    $.cookie("sortType", sort.type, {
        expires : 10,
        path    : '/'
    });
    location.reload();
}

keywords = {
    getKeywordBut: function (name) {
        button = '<div class="btn-group keyword">';
        button += '<button type="button" class="btn btn-default btn-flat disabled" >'+name+'</button>';
        button += '<input type="hidden" value="'+name+'" class="input" name="keyword[]">';
        button += '<button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Список действий</span></button>';
        button += '<ul class="dropdown-menu" role="menu"><li class="keywordEdit"><a href="#" ><i class="fa fa-edit"></i>Редактировать</a></li><li class="keywordDelete"><a href="#" ><i class="fa fa-remove"></i>Удалить</a></li></ul></div>';
        return button;
    },

    initKeywordError: function () {
        $('input#keywordName').focus();
        $('input#keywordName').css('border-color', 'red');
        setTimeout(function () {
            $('input#keywordName').css('border-color', '#d2d6de');
        }, 5000);
        return false;
    },

    issetKeyword: function (name) {
        status = 0;
        $.each($('.keyword'), function (n,m) {
            inputVal = $(m).find('input').val();
            if(name === inputVal) {
                status = 1;
            }
        })
        return status;
    },

    addKeyword: function () {
        var sKeyword = $('input#keywordName').val().toLowerCase();
        sKeyword = $.trim(sKeyword);
        if(sKeyword.length > 0) {
            var but = keywords.getKeywordBut(sKeyword);
            if(keywords.issetKeyword(sKeyword) == 1) {
                keywords.initKeywordError();
                return false;
            }
            $('input#keywordName').val('');
            $('.keywordForm').hide();
            $(but).insertBefore('#addKeyword');
            $('#addKeyword').show();
        }else{
            keywords.initKeywordError();
            return false;
        }
    },

    showForm: function (text) {
        if (text === undefined) {
            text = '';
        }
        $('input#keywordName').val(text);
        $('.keywordForm').show();
        $('input#keywordName').focus();
    }
}

unpublish = {
    lot_id: 0,
    comment: '',
    token : $('input[name="_token"]').val(),
    getUnpublishInfo : function (nBidId) {
        this.lot_id = nBidId;
        oDat = {};
        oDat._token = this.token;
        oDat.id = nBidId;
        $.ajax({
            method: "POST",
            url: "/admin/lots/unpublish/get",
            data: oDat,
            beforeSend: function(){
                $.loader({
                    className:"blue-with-image-2",
                    content:''
                });
            },
            success: function(response) {
                if(response.success){
                    sComment = response.data.comment;
                    this.comment = sComment;
                    $.loader('close');
                    $('#unpublish-info').find('#info-lot-id').html(oDat.id);
                    $('#unpublish-info').find('#info-lot-comment').html(sComment);
                    $('#unpublish-info').find('#info-lot-updated').html(response.update_data);
                    $('#unpublish-info').modal('show');
                }else{
                    $.loader('close');
                    alert('Что-то пошло не так( попробуйте еще раз');
                    return false;
                }
            }
        });
    },
    getComment : function(nBidId) {
        this.lot_id = nBidId;
        oDat = {};
        sComment = '';
        oDat._token = this.token;
        oDat.id = nBidId;
        $.ajax({
            method: "POST",
            url: "/admin/lots/unpublish/get",
            data: oDat,
            beforeSend: function(){
                $.loader({
                    className:"blue-with-image-2",
                    content:''
                });
            },
            success: function(response) {
                if(response.success){
                    sComment = response.data.comment;
                    this.comment = sComment;
                    $.loader('close');
                    $('#unpublish-bid').find('#comment-text').html(sComment);
                    $('#unpublish-bid').modal('show');
                }else{
                    $.loader('close');
                    alert('Что-то пошло не так( попробуйте еще раз');
                    return false;
                }
            }
        });
    },
    blockAction : function (textComment) {
        var ajaxUrl = $('#blocked-form').attr('action');
        this.sendAction('blocked', textComment, ajaxUrl);
    },
    approveAction : function (textComment) {
        var ajaxUrl = $('#approve-form').attr('action');
        this.sendAction('approve', textComment, ajaxUrl);
    },
    sendAction : function (action, textComment, ajaxUrl) {
        oDat = {};
        oDat._token = this.token;
        oDat.lot_id = this.lot_id;
        oDat.action = action;
        oDat.comment = textComment;
        $.ajax({
            method: "POST",
            url: ajaxUrl,
            data: oDat,
            beforeSend: function(){
                $.loader({
                    className:"blue-with-image-2",
                    content:''
                });
            },
            success: function(response) {
                if(response.success){
                    location.reload();
                }else{
                    $.loader('close');
                    if(typeof response.msg != 'undefined') {
                        alert(response.msg);
                    } else {
                        alert('Что-то пошло не так( попробуйте еще раз');
                    }
                    return false;
                }
            }
        })
    }
}

$(function() {
    $('input#inputPostDate, input#inputInpDate').daterangepicker({
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD.MM.YYYY',
            applyLabel: "Да",
            cancelLabel: "Отмена",
            fromLabel: "От",
            toLabel: "До",
            customRangeLabel: "Свое",
            weekLabel: "Н",
            daysOfWeek: [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            monthNames: [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            firstDay: 1
        }
    });

    $('input#inputEnd').datepicker({
        format: 'dd.mm.yyyy',
        language:'ru-RU'

    });

    $('input#inputPostDate, input#inputInpDate').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
    });

    $('input#inputPostDate, input#inputInpDate').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#length').on('change', function(){
        var val = $(this).val();
        $.cookie("pageCount", val, {
            expires : 10,
            path    : '/'
        });
        location.reload();
    })
    $('#tryFilter').on('click', function(){
        datasObj = {};
        $('#filterForm input[type="text"]').each(function (n,m) {
            if($(m).val()!==''){
                name = $(m).data('name');
                datasObj[name] = $(m).val();
            }
        });
        $('#filterForm select[name="region"]').each(function (n,m) {
            if($(m).val()!==''){
                name = $(m).data('name');
                datasObj[name] = $(m).val();
            }
        });
        $('#filterForm select[name="status"]').each(function (n,m) {
            if($(m).val()!==''){
                name = $(m).data('name');
                datasObj[name] = $(m).val();
            }
        });
        $('#filterForm select[name="category"]').each(function (n,m) {
            if($(m).val()!==''){
                name = $(m).data('name');
                datasObj[name] = $(m).val();
            }
        });



        if(Object.keys(datasObj).length > 0){
            urlData = $.param(datasObj, true );
            var url = window.location.href.replace( /[\?#].*|$/, "" );
            console.log(urlData.length);
                url += '?'+urlData;
            window.location.href = url;
        }
        return false;
    })

    $(document).on('click', '.sel_cat' , function () {
        getChildsCategories($(this).data('parent'));
        $("#category").select2('open');
        getCatsFamily($(this).data('parent'));
        return false;
    });
    
    $('#category').on('select2:select', function (evt) {
        var sel_id = evt.params.data.id;
        getChildsCategories(sel_id);
        $("#category").select2('open');
    });

    $('#filterForm').submit(function () {
        datasObj = {};
        $('#filterForm input[type="text"]').each(function (n,m) {
            if($(m).val()!==''){
                name = $(m).data('name');
                datasObj[name] = $(m).val();
            }
        });
        if(Object.keys(datasObj).length > 0){
            urlData = $.param(datasObj, true );
            var url = window.location.href.replace( /[\?#].*|$/, "" );
            url += '?'+urlData;
            window.location.href = url;
        }else{
            var url = window.location.href.replace( /[\?#].*|$/, "" );
            window.location.href = url;
        }
        return false;
    })
    $('input[name="btSelectAll"]').on('change', function(){
        check = $(this).prop( "checked" );
        $('tbody').children().each(function (n,m) {
            if(check){
                $(m).find('input[name="btSelectItem"]').prop( "checked", true );
            } else {
                $(m).find('input[name="btSelectItem"]').prop( "checked", false );
            }
        })
    })
    $('#resetFilter').on('click', function () {
        $('#filterForm input[type="text"]').each(function (n,m) {
            $(m).val('');
        });
        $('#filterForm').trigger('submit');
    })

    $('#itemsTable th').on('click', function(){
        if(!$(this).hasClass('sortFlag')) return null;
        col = $(this).data('col');
        if(col == sort.col){
            toggleSort();
        } else {
            sort.col = col;
            sort.type = 'asc';
            applySort();
        }
        return true;
    })

    $('#export_table, #export_table1').on('click', function(){
        var type = $(this).prev().children('select').val();
        var oDat = {};
        switch (type){
            case 'all':
                //empty data
                break;
            case 'filter':
                //data from filter form
                $('#filterForm input[type="text"]').each(function (n,m) {
                    if($(m).val()!==''){
                        name = $(m).data('name');
                        oDat[name] = $(m).val();
                    }
                });
                if(Object.keys(oDat).length == 0){
                    return false;
                }
                break;
            case 'selected':
                //get selected ids
                ids = [];
                $('tbody').children().each(function (n,m) {
                    var check = $(m).find('input[name="btSelectItem"]').prop( "checked");
                    if(check) {
                        console.log($(m).find('input[name="btSelectItem"]').data('index'));
                        ids.push($(m).find('input[name="btSelectItem"]').data('index'));
                    }
                })
                if(Object.keys(ids).length == 0){
                    return false;
                } else {
                    oDat.ids = ids;
                }
                break;
        }
        oDat._token = $('input[name="_token"]').val();
        $.ajax({
                method: "POST",
                url: "/admin/export",
                data: oDat,
                beforeSend: function(){
                    $.loader({
                        className:"blue-with-image-2",
                        content:''
                    });
                },
                success: function(response) {
                    if(response.success){
                        a = document.createElement('a');
                        a.href = response.link;
                        a.style.display = 'none';
                        document.body.appendChild(a);
                        a.click();
                        $.loader('close');
                    }else{
                        $.loader('close');
                        alert('Что-то пошло не так( попробуйте еще раз');
                    }
                }
            });
    })

    if($('input[name="isProvider"][checked]').val() == '1') {
        var provider_block = $('.provider-block');
        provider_block.show();
    }

    $('input[name="isProvider"]').on('change', function(){
            var value = parseInt($(this).val());
            var provider_block = $('.provider-block');
            if(value) {
                provider_block.show();
            } else {
                provider_block.hide();
            }
    })

    params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v})

    $('.j-change-type').on('click', function(){
        delete params.page;
        var get_params = $.param(params);
        var cur_page = window.location.pathname;
        if($(this).data('link') !== cur_page) {
            window.location.href  = $(this).data('link') + (get_params.length > 0 ? '?' : '') + get_params;
        }
        return false;
    });

    $('#addKeyword').on('click', function(){
        $(this).hide();
        keywords.showForm();
    })

    $('#saveKeyword').on('click', function(){
        keywords.addKeyword();
    })

    $("#keywordName").keydown(function (e) {
        if (e.keyCode == 13) {
            keywords.addKeyword();
            return false;
        }
    });

    $(document).on('click','.keywordDelete', function() {
        $(this).closest('.keyword').remove();
    })

    $(document).on('click','.keywordEdit', function() {
        var block = $(this).closest('.keyword');
        var name = $(block).find('input').val();
        keywords.showForm(name);
        $(block).remove();
    })

    $('#add_category').validate({

        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 100
            }
        }
    });

    $('#add-user-form').validate({

        rules: {
            email: {
                required: true,
                minlength: 6,
                maxlength: 100
            },
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            company: {
                required: true,
                minlength: 3,
                maxlength: 75
            },
            region: {
                required: true
            },
            telephone: {
                required: true
            }
        }
    });

    $('.show-unpub-modal').on('click', function () {
        var nUnpubId = $(this).data('id');
        //получаем данные о комментарии
        var comment = unpublish.getComment(nUnpubId);
        //показываем окно
    })

    $('.show-unpub-info-modal').on('click', function () {
        var nUnpubId = $(this).data('id');

        var comment = unpublish.getUnpublishInfo(nUnpubId);
    })
    
    $('#blocked-unpub').on('click', function () {
        $('#unpublish-blocked').modal('show');
    })

    $('#approve-unpub').on('click', function () {
        $('#unpublish-approve').modal('show');
    })
    
    $('#blocked-form').validate({
        rules: {
            comment: {
                required: true,
                minlength: 20,
                maxlength: 200
            }
        }
    })
    $('#approve-form').validate({
        rules: {
            comment: {
                required: true,
                minlength: 20,
                maxlength: 200
            }
        }
    })
    $('#item_form').validate({
        rules: {
            per_price: {
                maxlength: 10
            }
        }
    })
    
    $('#blocked-bid').on('click', function () {
        if(!$('#blocked-form').valid()) {
            return false;
        }
        $('#comment-input').validate();
        var text = $('#unpublish-blocked').find('#comment-input').val();
        if(text.length > 20) {
            unpublish.blockAction(text);
        } else {
            alert('Комментарий должен содержать более 20 символов...');
            $('#unpublish-blocked').find('#comment-input').css('border-color', 'red');
            return false;
        }
    })

    $('#approve-bid').on('click', function () {
        if(!$('#approve-form').valid()) {
            return false;
        }
        var text = $('#unpublish-approve').find('#comment-input').val();
        if(text.length > 20) {
            unpublish.approveAction(text);
        } else {
            alert('Комментарий должен содержать более 20 символов...');
            $('#unpublish-approve').find('#comment-input').css('border-color', 'red');
            return false;
        }
    })

    /*Загрузка документов в профиле пользователя*/
    $('#load-documents').fileinput({
        uploadUrl: routes.filesUpload, // server upload action
        uploadAsync: false,
        showUpload: false,
        showRemove: false,
        showPreview: true,
        maxFileCount: 8,
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { // configure your icon file extensions
            'doc': '<i class="glyphicon glyphicon-file"></i>'
        },
        previewFileExtSettings: { // configure the logic for determining icon file extensions
            'doc': function(ext) {
                return ext.match(/()$/i);
            }
        },
        uploadExtraData: function (previewId, index) {
            var info = {_token: $('input[name="_token"]').val(), type:'profiledocs'};
            return info;
        }
    }).on("filebatchselected", function(event, files) {

        if(files.length == 0) {
            return false;
        } else {
            $('#load-documents').fileinput("upload");
        }

    });
    $('#load-documents').on('filebatchuploadsuccess', function(event, data) {
        $('#filesUpload_documents').val(data.response.file);
    });

    //delete selected item
    $('.button-delete').on('click', function () {
        //open modal window
        $('#deleteModal').modal('show');
        //set fields
        $('.multiple-form').attr('action', $(this).data('href'));
    });


});
jQuery.validator.addMethod("lettersonly", function(value, element)
{
    return this.optional(element) || /^[а-яА-Яa-zA-Z0-9]+$/i.test(value);
}, "Допустимы только буквы");