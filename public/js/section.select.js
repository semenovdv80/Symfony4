$(function () {
    $('#section-select').on('keyup', function(){
        if (this.value.match(/[^ ]/g)) {
            this.value = this.value.replace(/[^ ]/g, '');
        }
    });

    $('#section-select').on('click', function () {
        $(this).attr('value','');
        oDat = {};
        oDat._token = $('input[name="_token"]').val();
        oDat.title = $('#title').val();
        oDat.type =  'titleHint';
        $.ajax({
            type: "POST",
            url: routes.hintCompany,
            data: oDat,
            beforeSend: function () {
                $('#section-selector-window').modal('show');
                $('#section-selector-window #second-step-window').hide();
                $('#section-selector-window #first-step-window').show();
                $('#section-selector-window #process-loader').show();
            },
            success: function (response) {
                if (response && response.success) {
                    if (response.data) {
                        $('#first-step-window .recomended').html('<h4>'+response.data.text+'</h4>');
                        var list = $('<ul></ul>');
                        $(response.data.sections).each(function (n,m) {
                            list.append('<li><a class="section" href="#" data-id="'+m.id+'" data-title="'+m.text+'">'+m.text+'</a></li>')
                        })
                        $('#first-step-window .recomended').append(list);
                    }
                }
                $('#section-selector-window #process-loader').hide();
            },
            error: function (msg) {
                alert(msg.status + ' ' + msg.statusText);
            }
        })
    })

    $(document).on('click', '.section',function () {
        var nSectionId = $(this).data('id');

        oDat = {};
        oDat._token = $('input[name="_token"]').val();
        oDat.sectionId = nSectionId;
        oDat.type =  'sectionClick';
        $.ajax({
            type: "POST",
            url: routes.hintCompany,
            data: oDat,
            beforeSend: function () {
                $('#section-selector-window').modal('show');
                $('#section-selector-window #second-step-window').hide();
                $('#section-selector-window #first-step-window').hide();
                $('#section-selector-window #process-loader').show();
            },
            success: function (response) {
                if (response && response.success) {
                    if (!response.has_child) {
                        var linkSelection = $('<a></a>');
                        linkSelection.prop('href', '#').addClass('link-selection');
                        var link = '';
                        $(response.data).each(function (n,m) {
                            if(n > 0) {
                                link += ' &raquo; ' + m.title;
                            } else {
                                link += m.title;
                            }
                        })
                        linkSelection.append(link);
                        $('#section-select').hide();
                        $('#select-links').html(linkSelection);
                        $('#section-id-error').hide();
                        $('#section-selector-window').modal('hide');
                        $('#section-id').val(nSectionId);
                    } else {
                        $('.section-column').each(function (l,k) {
                            $(k).hide();
                            $(k).removeClass('active')
                        })
                        $(response.list).each(function (n,m) {
                            var column = $('#second-step-window').find('.column'+n);
                            column.show();

                            var columnList = column.find('ul');
                            columnList.html('');
                            $(m).each(function (s,t) {
                                var elemLi = '<li><a class="section" href="#" data-id="'+t.id+'" data-title="'+t.name+'" title="'+t.name+'">'+t.name.substring(0, 23)+(t.name.length>23?'...':'')+(t.has_child=='1'?'&raquo':'')+'</a></li>';
                                columnList.append(elemLi);
                            })
                        })

                        $(response.selected).each(function (n,m) {
                            var activeColumn = $('#second-step-window').find('.column'+n);
                            activeColumn.addClass('active');
                            $('#second-step-window').find('.column'+(n+1)).children('.col-title').html(m.section.name.substring(0, 26)+(m.section.name.length>26?'...':''));
                            activeColumn.children('ul').children('li').each(function(r, elemLi) {
                                var link = $(elemLi).children('a');
                                if(link.data('id')==m.id) {
                                    $(elemLi).addClass('active');
                                    var liPosition = $(elemLi).position().top;
                                    activeColumn.scrollTop(activeColumn.scrollTop() + liPosition);
                                }
                            });


                        });

                        $('#section-selector-window #first-step-window').hide();
                        $('#second-step-window').show();
                        document.getElementById('second-step-window').scrollLeft += 150;


                    }
                }
                $('#section-selector-window #process-loader').hide();
            },
            error: function (msg) {
                alert(msg.status + ' ' + msg.statusText);
            }
        })
        return false;
    })

    $(document).on('click', '.link-selection', function () {
        var nSectionId = $('#section-id').val();

        oDat = {};
        oDat._token = $('input[name="_token"]').val();
        oDat.sectionId = nSectionId;
        oDat.type =  'sectionClickEdit';
        $.ajax({
            type: "POST",
            url: routes.hintCompany,
            data: oDat,
            beforeSend: function () {
                $('#section-selector-window').modal('show');
                $('#section-selector-window #second-step-window').hide();
                $('#section-selector-window #first-step-window').hide();
                $('#section-selector-window #process-loader').show();
            },
            success: function (response) {
                if (response && response.success) {
                        $('.section-column').each(function (l,k) {
                            $(k).hide();
                            $(k).removeClass('active')
                        })
                        $(response.list).each(function (n,m) {
                            var column = $('#second-step-window').find('.column'+n);
                            column.show();
                            $('#second-step-window').bind()
                            console.log($('#second-step-window').scrollLeft(), column.position().left);
                            var columnList = column.find('ul');
                            columnList.html('');
                            $(m).each(function (s,t) {
                                var elemLi = '<li><a class="section" href="#" data-id="'+t.id+'" data-title="'+t.name+'" title="'+t.name+'">'+t.name.substring(0, 23)+(t.name.length>23?'...':'')+(t.has_child=='1'?'&raquo':'')+'</a></li>';
                                columnList.append(elemLi);
                            })
                        })
                        $(response.selected).each(function (n,m) {
                            var activeColumn = $('#second-step-window').find('.column'+n);
                            activeColumn.addClass('active');
                            $('#second-step-window').find('.column'+(n+1)).children('.col-title').html(m.section.name.substring(0, 26)+(m.section.name.length>26?'...':''));
                            activeColumn.children('ul').children('li').each(function(r, elemLi) {
                                var link = $(elemLi).children('a');
                                if(link.data('id')==m.id) {
                                    $(elemLi).addClass('active');
                                    var liPosition = $(elemLi).position().top;
                                    activeColumn.scrollTop(activeColumn.scrollTop() + liPosition);
                                }
                            })
                        })
                        $('#section-selector-window #first-step-window').hide();
                        $('#second-step-window').show();
                }
                $('#section-selector-window #process-loader').hide();
            },
            error: function (msg) {
                alert(msg.status + ' ' + msg.statusText);
            }
        })
        return false;
    })
})