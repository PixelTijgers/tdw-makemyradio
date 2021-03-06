common.View.create('admin.modules.page.CreateEdit', {

    onDOMLoad()
    {
        this.initTest();
        this.initCloneScript();
        this.initClone();
        this.initSortable();
    },

    initTest() {
        console.log('Init: admin.modules.page.CreateEdit');
    },

    initCloneScript() {

        (function($) {

            $.fn.cloneData = function(options, callback) {

                var settings = jQuery.extend({
                    mainContainerId: "clone-container",
                    cloneContainer: "clone-item",
                    excludeHTML: ".exclude",
                    emptySelector: ".empty",
                    copyClass: "clone-div",
                    removeButtonClass: "remove-item",
                    removeConfirm: false,
                    removeConfirmMessage: 'Are you sure want to delete?',
                    append: '',
                    template: null,
                    clearInputs: true,
                    maxLimit: 0, // 0 = unlimited
                    minLimit: 1, // 0 = unlimited
                    minLimitAlert: '', // 0 = unlimited
                    defaultRender: true, // true = render/initialize one clone
                    counterIndex: 0,
                    select2InitIds: [],
                    ckeditorIds: [],
                    regexID: /^(.+?)([-\d-]{1,})(.+)$/i,
                    regexName: /(^.+?)([\[\d{1,}\]]{1,})(\[.+\]$)/i,
                    init: function() {},
                    complete: function() {},
                    beforeRender: function() {},
                    afterRender: function() {},
                    beforeRemove: function() {},
                    afterRemove: function() {},
                }, options);

                if (typeof callback === 'function') { // make sure the after callback is a function
                    callback.call(this); // brings the scope to the after callback
                }

                // call the beforeRender and apply the scope:
                //console.log('init called from library'+ $('#' + settings.mainContainerId).find('.'+settings.cloneContainer).length);
                settings.init.call({index: settings.counterIndex});

                var _addItem = function () {

                    settings.counterIndex = $('.' + settings.cloneContainer).length;
                    settings.beforeRender.call(this);

                    var item_exists = $('.' + settings.cloneContainer).length;

                    // stop append HTML if maximum limit exceed
                    if (settings.maxLimit != 0 && item_exists >= settings.maxLimit){
                        alert("More than "+ settings.maxLimit +" degrees can\'t be added in one form. Please 'Add New'.");
                        return false;
                    }

                    // $('#' + settings.mainContainerId).append(settings.template.first()[0].outerHTML);

                    const reference = $(settings.template.first()[0].outerHTML);

                    reference.appendTo('#' + settings.mainContainerId);

                    $(reference.get(0)).removeClass('d-none');

                    _initializePlugins();
                    _updateAttributes();

                    // afterRender.apply(this, Array.prototype.slice.call(arguments, 1));
                    //$(settings.template.first()[0].outerHTML).trigger('afterRender');
                    ///$elem.closest('.' + widgetOptions.widgetContainer).triggerHandler(events.limitReached, widgetOptions.limit);

                    settings.afterRender.call({index: reference});
                    return false;
                }

                var _updateAttributes = function () {

                    $('.' + settings.cloneContainer).each(function(index) {
                        $(this).find('*').each(function() {
                            _updateAttrID($(this), index);
                            _updateAttrName($(this), index);
                        });
                    });

                    $('#' + settings.mainContainerId).addClass('clone-data');
                    $('#' + settings.mainContainerId + ' .' + settings.cloneContainer).each(function(parent_index, item){
                        $(this).attr('data-index', parent_index).addClass(settings.copyClass);
                    });

                    $('#' + settings.mainContainerId + ' .' + settings.cloneContainer + ' .hidden-lft').each(function(parent_index, item){
                        $(this).val(parent_index)
                    });

                    $('.' + settings.cloneContainer + '.' + settings.copyClass).each(function(parent_index, item) {
                        $(item).find('[for]').each(function(){
                            $(this).attr('for', $(this).attr('for').replace(/.$/, parent_index));
                        });

                        settings.complete({index: settings.counterIndex});

                    });
                }

                var _updateAttrID = function($elem, index) {
                    //var widgetOptions = eval($elem.closest('div[data-dynamicform]').attr('data-dynamicform'));
                    var id            = $elem.attr('id');
                    var newID         = id;

                    if (id !== undefined) {
                            newID = _incrementLastNumber(id, index);
                            $elem.attr( 'id', newID);
                    }

                    if (id !== newID) {
                        $elem.closest('.'+settings.cloneContainer).find('.field-' + id).each(function() {
                            $(this).removeClass('field-' + id).addClass('field-' + newID);
                        });
                        // update "for" attribute
                        $elem.closest('.'+settings.cloneContainer).find("label[for='" + id + "']").attr('for',newID);
                    }

                    return newID;
                }

                var _incrementLastNumber = function (string, index) {
                    return string.replace(/[0-9]+(?!.*[0-9])/, function(match) {
                        return index;
                    });
                }

                var _updateAttrName = function($elem, index) {
                    var name = $elem.attr('name');

                    if (name !== undefined) {
                        var matches = name.match(settings.regexName);

                        if (matches && matches.length === 4) {
                            matches[2] = matches[2].replace(/\]\[/g, "-").replace(/\]|\[/g, '');
                            var identifiers = matches[2].split('-');
                            identifiers[0] = index;

                            if (identifiers.length > 1) {
                                var widgetsOptions = [];
                                $elem.parents('.'+settings.mainContainerId).each(function(i){
                                    widgetsOptions[i] = eval($(this).find('#'+settings.mainContainerId));
                                });

                                widgetsOptions = widgetsOptions.reverse();
                                for (var i = identifiers.length - 1; i >= 1; i--) {
                                    identifiers[i] = $elem.closest('#'+settings.mainContainerId).index();
                                }
                            }

                            name = matches[1] + '[' + identifiers.join('][') + ']' + matches[3];
                            $elem.attr('name', name);
                        }
                    }

                    return name;
                };

                var _parseTemplate = function() {
                    var template_clone = $('#' + settings.mainContainerId +' .' + settings.cloneContainer + ":first");

                    var $template = $(template_clone).clone(false, false);
                    //console.log($template);

                    $template.find('input, textarea, select').each(function() {
                        if ($(this).is(':checkbox') || $(this).is(':radio')) {
                            var type         = ($(this).is(':checkbox')) ? 'checkbox' : 'radio';
                            var inputName    = $(this).attr('name');
                            var $inputHidden = $template.find('input[type="hidden"][name="' + inputName + '"]').first();
                            var count        = $template.find('input[type="' + type +'"][name="' + inputName + '"]').length;

                            if ($inputHidden && count === 1) {
                                $(this).val(1);
                                $inputHidden.val(0);
                            }

                            //$(this).prop('checked', false);
                            $(this).removeAttr("checked");
                        } else if($(this).is('select')) {
                            $(this).find('option:selected').removeAttr("selected");
                        } else if($(this).is('textarea')) {
                            $(this).html("");
                        } else {
                            //$(this).val('');
                            $(this).removeAttr("value");
                        }

                    });

                    /* Remove chosen extra html */
                    $template.find('.chosen-container').each(function(){
                        $(this).remove();
                    });

                    if($template.find('.select2-container').length > 0){
                        $template.find('.select2-container').each(function(){
                            $(this).remove();
                        });
                    }

                    $template.find('.select2-container').remove();

                    //Remove Elements with excludeHTML
                    if (settings.excludeHTML){
                        $(settings.template).find(settings.excludeHTML).remove();
                    }

                    //Empty Elements with emptySelector
                    if (settings.emptySelector){
                        $(settings.template).find(settings.emptySelector).empty();
                    }

                    /* Render default HTML container */
                    if(!settings.defaultRender){
                        /* html remove after store and remove extra HTML */
                        $('.' + option.cloneContainer + ":first").remove();
                    }

                    //$template.find('input').find('input').val('');

                    //console.log($template.first()[0].outerHTML);
                    settings.template = $template;
                };

                var _initializePlugins = function(){
                    /* Initialize again chosen dropdown after render HTML */
                    if($('.chosen-init').length >0){
                        $('.chosen-init').each(function(){
                            $(this).chosen().trigger('chosen:update');
                        });
                    }

                    if($('.select2').length >0){
                        $('.select2').each(function(){
                            $(this).select2({ width: '100%' }).trigger('select2:update');
                        });
                    }

                    if($.fn.datepicker && $('.datepicker-init').length > 0) {
                        $('.datepicker-init').datepicker({autoclose: true});
                    }

                    if($.fn.datetimepicker && $('.datetimepicker-init').length > 0) {
                        $('.datetimepicker-init').datetimepicker({autoclose: true});
                    }

                    if ($.fn.select2 && settings.select2InitIds.length > 0) {
                        //console.warn(settings.select2InitIds);
                        $.each(settings.select2InitIds, function (index, id) {
                            $(id).select2({
                                placeholder: "Select",
                                width: "300px;",
                                allowClear: true
                            })

                        });
                        settings.select2InitIds = [];
                    }

                    if (window.CKEDITOR && settings.ckeditorIds.length > 0) {
                        $.each(settings.ckeditorIds, function (index, id) {
                            CKEDITOR.replace(id);

                            var $ids = $('[id=cke_' + id + ']');
                            if ($ids.length > 0) {
                                //console.log($ids);
                                $ids.remove();
                            }
                        });
                        settings.ckeditorIds = [];
                    }

                    if(typeof $.material !== 'undefined') {
                        $.material.init();
                    }
                }

                var _deleteItem = function($elem) {

                    var count = _count();
                    if (count > settings.minLimit) {
                        $elem.parents('.' + settings.cloneContainer).slideUp(function(){
                            $(this).remove();
                            _updateAttributes();
                            settings.afterRemove.call(this);
                            _initializePlugins();
                        });
                    }else{
                        alert('you must have at least one item.');
                    }
                };

                var _count = function() {
                    return $('.' + settings.cloneContainer).closest('#' + settings.mainContainerId).find('.'+settings.cloneContainer).length;
                };


                $(document).on('click', '.' + settings.removeButtonClass, function(){
                    settings.beforeRemove.call(this);
                    _deleteItem($(this));
                });


                // loop each element
                this.each(function() {
                    $(this).click(function(){
                        _addItem();
                    });
                    _parseTemplate();
                    _updateAttributes();
                });

                return this; // return to jQuery
            };

        })(jQuery);

    },

    initClone() {

        $('.addButton').cloneData({
            mainContainerId: 'nestedImages',
            cloneContainer: 'slider-item',
            removeButtonClass: 'closeButton',
            removeConfirm: false,
            minLimit: 1,
            maxLimit: 10,
            defaultRender: 1,
            init: function () {
                console.info(':: Initialize Plugin ::');
            },
            beforeRender: function () {
                console.info(':: Before rendered callback called');
            },
            afterRender: function (event) {
                console.info(':: After rendered callback called');

                $('.pageSlide').last().dropify({
                });
            },
            afterRemove: function () {
                console.warn(':: After remove callback called');
            },
            beforeRemove: function () {
                console.warn(':: Before remove callback called');
            }

        });
    },

    initSortable()
    {
        $('#nestedImages').sortable({
            items: 'li',
            cursor: 'grabbing',
            opacity: 0.6,
            update: function() {

                $('#nestedImages li').each(function(index, element) {
                    $(this).find('.hidden-lft').val(index);
                });
            }
        });

    },

})
