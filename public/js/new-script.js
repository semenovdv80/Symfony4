$(function() {
    function clearForm() {
        $('form input[type="text"]').val('');
        $('.bootstrap-tagsinput span').html('');
        var region_reset = $('#new-subscribe #region').children(':first-child').val();
        $('#new-subscribe #region').select2().val(region_reset).trigger("change");
        $('#section-id').val('');
        $('.link-selection').remove();
        $('#section-select').show();
    };
    $('.tooltip-wrapper').tooltip({
        position: "bottom"
    });

    $('#region').select2();
    $('.wysiwyg').summernote();

    $('.timepicker').timepicker({
        minuteStep: 30,
        appendWidgetTo: '.timepick',
        showSeconds: false,
        showMeridian: false
    });

    $('input#pub-date, input#end-date').datepicker({
        format: 'dd.mm.yyyy',
        language:'ru'
    }).on('changeDate', function (e) {
        console.log(e);
        $(this).siblings('.timestamp').html(e.date.getTime());
    });


    $('#openModal').on('click', function(e) {
        e.preventDefault();
    });

    $('#submit-subscribe').on('click', function() {
        $('#new-subscribe').submit();
    });

    var result = false;

    $('#new-subscribe').validate({
        rules: {
            priceFrom: {
                required: false,
                number: true
            },
            priceTo: {
                required: false,
                number: true,
                maxlength: 10
            }
        }
    });



    $('#select-links').on("DOMSubtreeModified", function(){ //тригерим событие для хидден инпута, а то иначе какого-то лешого не работает

         $('#section-id').trigger('change');
    });


    $('#new-subscribe input, #new-subscribe select, #section-id').change(function () {
        var dateFlag = true;
        var priceFlag = true;
        var selectFlag = true;
        var sectionFlag = true;
        var errorFlag = true;
        var dateStart = +$('#pub-date').siblings('.timestamp').text();
        var dateEnd = +$('#end-date').siblings('.timestamp').text();
        var priceFrom = +$('#priceFrom').val();
        var priceTo = +$('#priceTo').val();
        var fields = $(this).parents('#new-subscribe').find('input[type="text"], #section-id');
        var select = $(this).parents('#new-subscribe').find('#region');

        if (dateStart > dateEnd && dateStart !==0 && dateEnd !== 0) {
            $('.wrong-date').removeClass('hidden');
            dateFlag = false;
        }
        else  {
            $('.wrong-date').addClass('hidden');
            dateFlag = true;
        }
        if (priceFrom > priceTo && priceTo !== 0 && priceFrom !== 0) {
            $('.wrong-price').removeClass('hidden');
            priceFlag = false;
        }
        else  {
            $('.wrong-price').addClass('hidden');
            priceFlag = true;
        }
        var sum = 0;
        for(var i = 0; i < fields.length; i++) {
            sum += fields[i].value.length;
            if(sum  > 0) {
                result = true;
            }
            else  {
                result = false;
            }
        }
        if (select.val() != null) {
            selectFlag = true;
        }
        else  {
            selectFlag = false;
        };
        if ($('.link-selection').text().length > 0) {
            sectionFlag = true;
        }
        else {
            sectionFlag = false;
        }
        if($('#priceFrom-error').text().length > 0 || $('#priceTo-error').text().length > 0  ) {
            errorFlag = false;
        }

        if((!result && !selectFlag && !sectionFlag) ||  !dateFlag || !priceFlag || !errorFlag) {
            $('#openModal').addClass('disabled');
            $('.submit-w').addClass('disabled');
            $('#openModal').prop("disabled", true);
        }
        else  {
            $('#openModal').removeClass('disabled');
            $('.submit-w').removeClass('disabled');
            $('#openModal').prop("disabled", false);
        }
    })



    $('.subscribe-del').on('click', function (e) {
        e.preventDefault();
        var data = {};
        data._token = $('input[name="_token"]').val()
        data.id = $(this).data('id');

        $.ajax({
            url: '/admin/subscribe/delete',
            type: 'delete',
            data: data,
            success: function(result) {
                $('#subscribe'+data.id).find('.modal-body').html(result.message);
                $('#subscribe'+data.id).find('.subscribe-del').remove();
                $('#subscribe'+data.id).find('.modal-footer .close-modal').removeClass('hidden');
                if(result.success == true) {
                    $('#subscribe'+data.id).on('hidden.bs.modal', function () {
                        $('#subscribe-item'+data.id).remove();
                    });
                }
            }
        })
    })

    $('.delete-template').on('click', function (e) {
        var button = $(this);
        e.preventDefault();
        var data = {};
        data._token = $('input[name="_token"]').val()
        data.id = $(this).data('id');

        $.ajax({
            url: '/admin/mail/letters/delete',
            type: 'delete',
            data: data,
            success: function(result) {
                $('#template'+data.id).find('.modal-body').html(result.message);
                $('#template'+data.id).find('.delete-template').remove();
                $('#template'+data.id).find('.modal-footer .close-modal').removeClass('hidden');
                if(result.success == true) {
                    $('#template'+data.id).on('hidden.bs.modal', function () {
                        $('#template-item'+data.id).remove();
                    });
                }
            }
        })
    })


    $('#clear-form').on('click', function(e) {
        e.preventDefault();
        clearForm();
    })

    $('.tags-input').tagsinput({
        confirmKeys: [13, 32, 44]
    });

    $('.macros').on('click', function (e) {
        var ta = $('.note-codable'),
            p = ta[0].selectionStart,
            text = ta.val();
        if(p != undefined)
            ta.val(text.slice(0, p) + $(this).val() + text.slice(p));
        else{
            ta.trigger('focus');
            range = document.selection.createRange();
            range.text = $(this).val();
        }
        // $('.note-editable.panel-body p').append($(this).val());
    })

    $('#new-timepicker').on('click', function() {
        $('<div class="timepick input-group"><input class="form-control timepicker" name="send_time[]" style="width: 250px"></div>').appendTo('.timepicker_w');
        $('.timepicker').timepicker({
            minuteStep: 30,
            appendWidgetTo: '.timepick',
            showSeconds: false,
            showMeridian: false
        });
    })
    $('#timepicker-remove').on('click', function () {
        $('.timepick').last().remove();
    })

    //Procurement add block
    /*$( "#add-procurement-form #company" ).autocomplete({
            source: function(request, response){
                oDat = {type:'category', term:request.term};
                oDat._token = $('input[name="_token"]').val();
                $.ajax({
                    type: "POST",
                    url: routes.hintCustomer,
                    data: oDat,
                    success: function (msg) {
                        if(msg.success && msg.count>0) {
                            response(msg.items);
                        } else {
                            console.log(msg);
                        }
                    },
                    error: function (msg) {
                        console.log(msg);
                        alert(msg.status + ' ' + msg.statusText);
                    }
                })
            },
            select: function (event, ui) {
                addProcurement.choseCustomer(ui.item);
                addProcurement.setCustomerInfo(ui.item);

                $("#company").val(ui.item.company);
                $('#user_id').val(ui.item.id);
                $('#email').val(ui.item.email);
                $('#phone').val(ui.item.phone);
                $('#email').prop('disabled', true);
                return false;
            },
            minLength: 2,
        })
        .autocomplete( "instance" )._renderItem = function (ul, item) {
        return $("<li class=\"select2-results__option\"></li>")
            .data("item.autocomplete", item)
            .append('<span>'+item.company+'</span></br><span class="text-muted">тел. '+item.phone+'</span></br><span class="text-muted">email. '+item.email+'</span>')
            .appendTo(ul);
    };*/

    $('#add-procurement-form .next-step').on('click', function () {
        var nextSelector = $(this).data('next');
        var thisWindow = $(this).parents('.step');

        var progressWidth = $('.progress .progress-bar').data('valuenow');
        var newWidth = progressWidth + 20;
        if(newWidth > 100) {
            newWidth = 100
        }
        $('.progress .progress-bar').data('valuenow', newWidth);
        $('.progress .progress-bar').css('width', newWidth+'%');
        thisWindow.hide();
        $(nextSelector).show();
    })

    $('.procurement-type').on('click', function () {
        var type = $(this).data('type');
        addProcurement.setProcurementType(type);
    })

    $('#load-files').fileinput({
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
            var info = {_token: $('input[name="_token"]').val(), type:'files'};
            return info;
        }
    }).on("filebatchselected", function(event, files) {
        $('#load-files').fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data) {
        $('#filesUpload').val(data.response.file);
    });
    
    $('#add-lot').on('click', function () {
        var lotData = addProcurement.updateLotsListInfo();
        addProcurement.clearLotInfoForm();

        addProcurement.addLotToTable(lotData);
    })

    //-------Procurement add end

})

var addProcurement = {
    lotsData : [],
    choseCustomer : function (customerData) {
        $('#add-procurement-form #cus-info-company').html(customerData.company);
        $('#add-procurement-form #cus-info-name').html(customerData.full_name);
        $('#add-procurement-form #cus-info-email').html(customerData.email);
        $('#add-procurement-form #cus-info-phone').html(customerData.phone);
        $('#add-procurement-form #cus-info-region').html(customerData.region);
        $('#add-procurement-form #customer-info').show();
    },
    setCustomerInfo : function (customerData) {
        var customenForm = $('#customer-info-form');
        customenForm.find('input[name="user_id"]').val(customerData.user_id);
        customenForm.find('input[name="email"]').val(customerData.email);
        customenForm.find('input[name="name"]').val(customerData.full_name);
        customenForm.find('input[name="phone"]').val(customerData.phone);
        customenForm.find('select[name="region"]').val(customerData.region_id);
        customenForm.find('input[name="company"]').val(customerData.company);
    },
    setProcurementType : function (type_id) {
        var procurementInfoForm = $('#procurement-info-form');
        procurementInfoForm.find('input[name="type"]').val(type_id);
    },
    updateLotsListInfo : function () {
        var lotInfoForm = $('#lot-info-form');
        var lotInfo = {};
        lotInfo.title = lotInfoForm.find('input[name="title"]').val();
        lotInfo.section_id = lotInfoForm.find('input[name="section_id"]').val();
        lotInfo.description = lotInfoForm.find('textarea[name="description"]').val();
        lotInfo.region_id = lotInfoForm.find('select[name="region"]').val();
        lotInfo.price_one = lotInfoForm.find('input[name="per_price"]').val();
        lotInfo.count = lotInfoForm.find('input[name="count"]').val();
        lotInfo.totalPrice = parseInt(lotInfo.price_one) * parseInt(lotInfo.count);
        lotInfo.measure = lotInfoForm.find('select[name="measure"]').val();
        lotInfo.files = lotInfoForm.find('input[name="filesUpload"]').val();
        lotInfo.files = lotInfoForm.find('input[name="filesUpload"]').val();

        addProcurement.lotsData.push(lotInfo);
        return lotInfo;
    },
    clearLotInfoForm : function () {
        var lotInfoForm = $('#lot-info-form');
        lotInfoForm.find('#title').val('');
        lotInfoForm.find('#section_id').val('');
        lotInfoForm.find('#select-links').html('');
        $('#section-select').show();
        lotInfoForm.find('#category').prop('disabled', false);
        this.resetCategory();
        lotInfoForm.find('#description').val('');
        lotInfoForm.find('#photoUpload').val('');
        lotInfoForm.find('#per_price').val('');
        lotInfoForm.find('#count').val('');
        var measure_reset = lotInfoForm.find('#measure').children(':first-child').val();
        lotInfoForm.find('#measure').select2().val(measure_reset).trigger("change");
        lotInfoForm.find('#category').select2().val('0').trigger("change");
        var region_reset = lotInfoForm.find('#region').children(':first-child').val();
        lotInfoForm.find('#region').select2().val(region_reset).trigger("change");
        lotInfoForm.find('#filesUpload').val('');
        lotInfoForm.find('.load-files').fileinput('clear');

        return true;
    },
    resetCategory : function () {
            $('#category').select2({
                ajax: {
                    url: routes.hintCustomer,
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function (params) {
                        params._token = $('input[name="_token"]').val();
                        params.title = $('#title').val();
                        return {
                            q: params.term,
                            _token: params._token,
                            type: 'hint',
                            title: params.title,
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data.items,
                        }
                    },
                    cache: true
                },
            });
    },
    addLotToTable : function (lotData) {
        var lotRow = '<tr><td style="width: 10px">'+this.lotsData.length+'</td><td>'+lotData.title+'</td> <td>'+lotData.count+'</td><th>'+lotData.totalPrice+'</th></tr>';
        $('#lotsInfoTable').children('tbody').append(lotRow);
        $('#public-procurement').prop('disabled', false)
    }
}