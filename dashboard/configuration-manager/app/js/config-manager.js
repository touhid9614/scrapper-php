var sMedia = sMedia || {};

function smedia_prepare_configuration($) {
    if (sMedia.ConfigReady)
        return;
    sMedia.ConfigReady = true;
    
    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };
    
    sMedia.Configuration = {
        initialized     : false,
        container       : null,
        template        : null,
        data            : null,
        Globals         : {},
        events          : {},
        controls        : {},
        control_space   : {},
        init            : function(container, template, data) {
            this.container      = container;
            this.template       = template;
            this.data           = data;
            this.initialized    = true;
        },
        on              : function(type, func) {
            if(type) {
                this.events[type] = this.events[type] || [];
                if(func) {
                    this.events[type].push(func);
                } else {
                    for(var i = 0; i < this.events[type].length; i++) {
                        this.events[type][i]();
                    }
                }
            }
        },
        unbind          : function(type, func) {
            if(type && func) {
                this.events[type] = this.events[type] || [];
                var index = this.events[type].indexOf(func);
                if (index > -1) {
                    this.events[type].splice(index, 1);
                }
            }
        },
        rendered        : function(func) {
            if(func) {
                this.on('rendered', func);
            } else {
                this.on('rendered');
            }
        },
        render          : function(inTabs = true) {
            var html = '';
            if(inTabs) {
                html += '<form class="form-horizontal form-bordered" method="POST">\n';
                html += '<div class=\"tabs\">\n';
                html += this.render_overview();
                html += '';
            }
            for(var name in this.template) {
                html += this.render_section(name);
            }
            if(inTabs) {
                html += '\t</div>\n';                       //End tab-content
            }
            html += '<footer class="panel-footer">\n';
            html += '<div class="col-lg-offset-2">';
            html += '<button class="btn btn-primary">Save </button>\n';
            html += '</div>\n';
            html += '</footer>\n';
            html += '</div>\n';                         //End tabs
            html += '</form>\n';
            
            $(this.container).html(html);
            
            for(var name in this.template) {
                $('#enable_' + this.name2id(name)).change(function(){
                    if(this.checked) {
                        $('#tab_' + $(this).attr('sm-data')).show();
                    } else {
                        $('#tab_' + $(this).attr('sm-data')).hide();
                    }
                });
                $('#enable_' + this.name2id(name)).change();
            }
            
            for(var k in this.controls) {
                this.controls[k].bind();
            }
            
            sMedia.Configuration.rendered();
        },
        render_overview : function() {
            var html = '\t<ul class=\"nav nav-tabs\">\n';
                html += '\t\t<li class=\"nav-item active\">\n';
                html += '\t\t\t<a class=\"nav-link\" href=\"#' + this.name2id('overview') + '\" data-toggle=\"tab\"> Overview</a>\n';
                html += '\t\t</li>\n';
            for(var name in this.template) {
                html += '\t\t<li id=\"tab_' + this.name2id(name) + '\" class=\"nav-item\">\n';
                html += '\t\t\t<a class=\"nav-link\" href=\"#' + this.name2id(name) + '\" data-toggle=\"tab\"> ' + this.template[name].name + '</a>\n';
                html += '\t\t</li>\n';
            }
            
            html += '\t</ul>\n';
            html += '\t<div class=\"tab-content\">\n';
            html += '\t\t<div id=\"' + this.name2id('overview') + '\" class=\"tab-pane active\">\n';
            
            html += '<div class=\"form-group row\">\n';
            html += '   <label class=\"col-lg-2 col-md-4 control-label\">Enable Configurations</label>\n';
            html += '       <div class=\"col-lg-6 col-md-8\">\n';
            for(var name in this.template) {
                if(this.template[name].required) {
                    html += '           <div class=\"checkbox-custom\">\n';
                    html += '               <input id=\"enable_' + this.name2id(name) + '\" sm-data=\"' + this.name2id(name) + '\" value=\"yes\" name=\"enable_' + name + '\" disabled=\"\" checked=\"\" type=\"checkbox\">\n';
                    html += '               <label for=\"enable_' + this.name2id(name) + '\">' + this.template[name].name + '</label>\n';
                    html += '           </div>\n';
                } else {
                    html += '           <div class=\"checkbox-custom checkbox-default\">\n';
                    html += '               <input id=\"enable_' + this.name2id(name) + '\" sm-data=\"' + this.name2id(name) + '\" value=\"yes\" name=\"enable_' + name + '\" ';
                    html += this.data['enable_' + name]?'checked=\"\"' : '';
                    html += ' type=\"checkbox\">\n';
                    html += '               <label for=\"enable_' + this.name2id(name) + '\">' + this.template[name].name + '</label>\n';
                    html += '           </div>\n';
                }
            }
            html += '   </div>\n';
            html += '</div>\n';
            
            html += '\t\t</div>\n';
            
            return html;
        },
        render_section  : function(name) {
            var html = '';
                html += '\t\t<div id=\"' + this.name2id(name) + '\" class=\"tab-pane\">\n';
                
                for(var fkey in this.template[name].fields) {
                    var ftype = this.template[name].fields[fkey].type;
                    
                    if(typeof sMedia.Configuration.Types[ftype] === 'function') {
                        var fobj = null;
                        if(this.template[name].fields[fkey].container) {
                            var ctype = this.template[name].fields[fkey].container;
                            fobj = new sMedia.Configuration.Containers[ctype](ftype, fkey,
                                    this.template[name].fields[fkey],
                                    typeof this.data[fkey] !== 'undefined'?this.data[fkey]:'');
                        } else {
                            fobj = new sMedia.Configuration.Types[ftype](fkey,
                                    this.template[name].fields[fkey],
                                    typeof this.data[fkey] !== 'undefined'?this.data[fkey]:'');
                        }
                        this.controls[fkey] = fobj;
                        html += fobj.render();
                    }
                }
                
                html += '\t\t</div>\n';
            return html;
        },
        name2id         : function(name) {
            return "smedia_elemid_" + name.replaceAll('[', '_').replaceAll(']', '');
        }
    };
    
    sMedia.Control = function (name, config, data) {
        this.id             = sMedia.Configuration.name2id(name);
        this.container_id   = this.id + '_container';
        this.label_id       = this.id + '_label';
        this.name           = name;
        this.config         = config;
        this.data           = data;
        sMedia.Configuration.control_space[name] = this;
    };
    
    sMedia.Control.prototype.show           = function() {
        $('#' + this.container_id).show();
    };
    
    sMedia.Control.prototype.hide           = function() {
        $('#' + this.container_id).hide();
    };
    
    sMedia.Control.prototype.render         = function() {
        
    };
    
    sMedia.Control.prototype.bind           = function() {
        
    };
    
    sMedia.Control.prototype.setName        = function(name) {
        var new_id          = sMedia.Configuration.name2id(name);
        var new_container   = new_id + '_container';
        var new_label       = new_id + '_label';
        
        $('#' + this.id).attr('name', name);
        $('#' + this.id).attr('id', new_id);
        $('#' + this.container_id).attr('id', new_container);
        $('#' + this.label_id).attr('for', new_id);
        $('#' + this.label_id).attr('id', new_label);
        
        delete sMedia.Configuration.control_space[this.name];
        sMedia.Configuration.control_space[name] = this;
        
        this.id             = sMedia.Configuration.name2id(name);
        this.container_id   = this.id + '_container';
        this.label_id       = this.id + '_label';
        this.name           = name;
    };
    
    sMedia.Control.prototype.setLabel       = function(text) {
        this.config.name = text;
        $('#' + this.label_id).html(text);
        if(this.config.required) {
            $('#' + this.label_id).append(' <span class="required">*</span>');
        }
    };
    
    sMedia.Control.prototype.setRequired    = function(required) {
        this.config.required = required;
        if(required) {
            $('#' + this.id).attr('required', 'true');
        } else {
            $('#' + this.id).removeAttr('required');
        }
    };
    
    sMedia.Composit  = function(name, config, data) {
        this.fields         = {};
        this.controls       = {};
        sMedia.Control.call(this, name, config, data);
    };
    
    sMedia.Composit.prototype = Object.create(sMedia.Control.prototype);
    
    sMedia.Composit.prototype.bind        = function() {
        for(var k in this.controls) {
            this.controls[k].bind();
        }
    };
    
    sMedia.Composit.prototype.setName       = function(name) {
        sMedia.Control.prototype.setName.call(this, name);
        
        for(var fkey in this.controls) {
            var fname = this.name + '[' + fkey + ']';
            this.controls[fkey].setName(fname);
        }
    };
    
    sMedia.Composit.prototype.render       = function() {
        var html = '';
            html    += "<div id=\"" + this.container_id + "\" class=\"sm-composit\">\n";
            html    += "<h4 id=\"" + this.label_id + "\">" + this.config.name + "</h4>";
            html    += "<hr/>";
            for(var fkey in this.fields) {
                var ftype = this.fields[fkey].type;
                var fname = this.name + '[' + fkey + ']';

                if(typeof sMedia.Configuration.Types[ftype] === 'function') {
                    var fobj = null;
                    if(this.fields[fkey].container) {
                        var ctype = this.fields[fkey].container;
                        fobj = new sMedia.Configuration.Containers[ctype](ftype, fname,
                                this.fields[fkey],
                                typeof this.data[fkey] !== 'undefined'?this.data[fkey]:'');
                    } else {
                        fobj = new sMedia.Configuration.Types[ftype](fname,
                                this.fields[fkey],
                                typeof this.data[fkey] !== 'undefined'?this.data[fkey]:'');
                    }
                    this.controls[fkey] = fobj;
                    html += fobj.render();
                }
            }
            html    += "<hr/>";
            html    += "</div>";
        return html;
    };
    
    sMedia.Container = function(type, name, config, data){
        this.contains       = type;
        this.children       = [];
        sMedia.Control.call(this, name, config, data);
    };
    
    sMedia.Container.prototype = Object.create(sMedia.Control.prototype);
    
    sMedia.Container.prototype.add = function(control) {
        
    };
    
    sMedia.Container.prototype.remove = function(control) {
        
    };
    
    sMedia.Container.prototype.bind        = function() {
        for(var k in this.children) {
            this.children[k].bind();
        }
    };
    
    sMedia.Configuration.Containers = {
        list        : function (type, name, config, data){
            if(!data) { data = ['']; }
            sMedia.Container.call(this, type, name, config, data);
            if(typeof sMedia.Configuration.Globals.Lists === 'undefined') { sMedia.Configuration.Globals.Lists = {}; }
            sMedia.Configuration.Globals.Lists[this.name] = this;
        }
    };
    
    sMedia.Configuration.Containers.list.prototype = Object.create(sMedia.Container.prototype);
    
    sMedia.Configuration.Containers.list.prototype.setName = function(name) {
        delete sMedia.Configuration.Globals.Lists[this.name];
        
        sMedia.Control.prototype.setName.call(this, name);
        
        sMedia.Configuration.Globals.Lists[this.name] = this;
        
        for(var k in this.children) {
            
            var fname = this.name + '[' + k + ']';
            this.children[k].setName(fname);
            
            var closer = $('#' + this.children[k].container_id).children('span.sm-list-delete');
            var adder = $('#' + this.children[k].container_id).children('span.sm-list-add');
            
            closer.attr('data-index', k);
            closer.attr('data-elem', this.children[k].container_id);
            closer.attr('id', this.children[k].container_id + '_closer');
            adder.attr('data-index', k);
            adder.attr('data-elem', this.children[k].container_id);
            adder.attr('id', this.children[k].container_id + '_adder');
            
            adder.attr('data-container', this.name);
            closer.attr('data-container', this.name);
        }
    };
    
    sMedia.Configuration.Containers.list.prototype.render = function() {
        var html = '';
            html    += "<div id=\"" + this.container_id + "\" class=\"sm-list-container\">\n";
            for(var k in this.data) {
                if(typeof sMedia.Configuration.Types[this.contains] === 'function') {
                    
                    var fkey = this.name + '[' + this.children.length + ']';
                    var nconfig = Object.assign({}, this.config);
                    if(this.children.length > 0) {
                        nconfig.name        = '';
                        nconfig.required    = false;
                    }
                    var fobj = new sMedia.Configuration.Types[this.contains](fkey,
                                    nconfig,
                                    this.data[k]);
                    this.children.push(fobj);
                    html += fobj.render();
                    
                }
            }
            html    += "</div>";
        return html;
    };
    
    sMedia.Configuration.Containers.list.prototype.bindChild = function(k) {
        $('#' + this.children[k].container_id).addClass('data-container-list');
        $('#' + this.children[k].container_id).append("<span data-container=\"" + this.name + "\" id=\"" + this.children[k].container_id + "_closer\" data-elem=\"" + this.children[k].container_id + "\" data-index=\"" + k + "\" class=\"sm-list-delete\"><i class=\"fa fa-close\"></i></span>");
        $('#' + this.children[k].container_id).append("<span data-container=\"" + this.name + "\" id=\"" + this.children[k].container_id + "_adder\" data-elem=\"" + this.children[k].container_id + "\" data-index=\"" + k + "\" class=\"sm-list-add\"><i class=\"fa fa-plus\"></i></span>");
        $('#' + this.children[k].container_id + "_closer").click(function() {
            var container = sMedia.Configuration.Globals.Lists[$(this).attr('data-container')];
            if(container.children.length === 1) { alert('Can\' remove all ' + container.config.name); return; } //Don't delete the last one

            var index = parseInt($(this).attr('data-index'));

            $('#' + $(this).attr('data-elem')).remove();

            container.children.splice(index, 1);
            for(var i = index; i < container.children.length; i++) {
                var fkey = container.name + '[' + i + ']';
                if(i === 0) {
                    container.children[i].setRequired(container.config.required);
                    container.children[i].setLabel(container.config.name);
                }
                container.children[i].setName(fkey);
                var closer = $('#' + container.children[i].container_id).children('span.sm-list-delete');
                var adder = $('#' + container.children[i].container_id).children('span.sm-list-add');
                closer.attr('data-index', i);
                closer.attr('data-elem', container.children[i].container_id);
                closer.attr('id', container.children[i].container_id + '_closer');
                adder.attr('data-index', i);
                adder.attr('data-elem', container.children[i].container_id);
                adder.attr('id', container.children[i].container_id + '_adder');
            }
        });
        $('#' + this.children[k].container_id + "_adder").click(function() {
            var container = sMedia.Configuration.Globals.Lists[$(this).attr('data-container')];
            var index = parseInt($(this).attr('data-index')) + 1;

            var fkey = container.name + '[' + index + ']';
            var nconfig = Object.assign({}, container.config);
            if(index > 0) {
                nconfig.name        = '';
                nconfig.required    = false;
            }
            var fobj = new sMedia.Configuration.Types[container.contains](fkey,
                                    nconfig,
                                    '');

            container.children.splice(index, 0, fobj);
            
            for(var i = container.children.length - 1; i > index; i--) {
                var nfkey = container.name + '[' + i + ']';
                if(i === 0) {
                    container.children[i].setRequired(container.config.required);
                    container.children[i].setLabel(container.config.name);
                }
                container.children[i].setName(nfkey);
                var closer = $('#' + container.children[i].container_id).children('span.sm-list-delete');
                var adder = $('#' + container.children[i].container_id).children('span.sm-list-add');
                closer.attr('data-index', i);
                closer.attr('data-elem', container.children[i].container_id);
                closer.attr('id', container.children[i].container_id + '_closer');
                adder.attr('data-index', i);
                adder.attr('data-elem', container.children[i].container_id);
                adder.attr('id', container.children[i].container_id + '_adder');
            }
            
            var html = fobj.render();
            
            $('#' + $(this).attr('data-elem')).after(html);
            
            container.bindChild(index);
        });
        this.children[k].bind();
    };
    
    sMedia.Configuration.Containers.list.prototype.bind = function() {
        for(var k in this.children) {
            this.bindChild(k);
        }
    };
    
    sMedia.Configuration.Types      = {
        hidden      : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        text        : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        textarea    : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        markdown    : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        html        : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        yesno       : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        color       : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        gradient    : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        date        : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        email       : function (name, config, data){
            sMedia.Control.call(this, name, config, data);
        },
        checkbox    : function (name, config, data) {
            sMedia.Control.call(this, name, config, data);
        },
        checklist    : function (name, config, data) {
            sMedia.Control.call(this, name, config, data);
        },
        radio       : function (name, config, data) {
            sMedia.Control.call(this, name, config, data);
        },
        dropdown    : function (name, config, data) {
            sMedia.Control.call(this, name, config, data);
        },
        textpair    : function (name, config, data) {
            sMedia.Control.call(this, name, config, data);
        },
        buttontext  : function (name, config, data) {
            sMedia.Composit.call(this, name, config, data);
            this.fields['name'] = { name: 'Text ID', type : 'text', required : true};
            this.fields['target'] = { name: 'Target', type : 'text', required : true};
            this.fields['values'] = { name: 'Values', type : 'text', required : true, container : 'list'};
        },
        styleeditor : function (name, config, data) {
            sMedia.Composit.call(this, name, config, data);
            this.fields['name'] = { name: 'Style Name', type : 'text', required : true};
            this.fields['normal'] = { name: 'Normal Style', type : 'textpair', required : true, container : 'list'};
            this.fields['hover'] = { name: 'Hover Style', type : 'textapir', required : true, container : 'list'};
        }
    };
    
    for(var fk in sMedia.Configuration.Types) {
        sMedia.Configuration.Types[fk].prototype = Object.create(sMedia.Control.prototype);
    }
    sMedia.Configuration.Types.buttontext.prototype = Object.create(sMedia.Composit.prototype);
    sMedia.Configuration.Types.styleeditor.prototype = Object.create(sMedia.Composit.prototype);
    
    sMedia.Configuration.Types.hidden.prototype.render      = function() {
        var html = '';
            html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "\" name=\"" + this.name + "\" type=\"hidden\" value=\"" + this.data + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        return html;
    };
    
    sMedia.Configuration.Types.text.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "\" name=\"" + this.name + "\" type=\"text\" value=\"" + this.data + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.textarea.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<textarea class=\"form-control\" rows=\"6\" id=\"" + this.id + "\" name=\"" + this.name + "\" " + (this.config.required?'required="true"':'') + ">" + this.data + "</textarea>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.markdown.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<textarea class=\"form-control\" data-plugin-markdown-editor rows=\"10\" id=\"" + this.id + "\" name=\"" + this.name + "\" " + (this.config.required?'required="true"':'') + ">" + this.data + "</textarea>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.html.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<textarea class=\"form-control\" data-plugin-codemirror data-plugin-options='{ \"mode\": \"text/xml\" }' rows=\"10\" id=\"" + this.id + "\" name=\"" + this.name + "\" " + (this.config.required?'required="true"':'') + ">\n" + this.data + "\n</textarea>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.yesno.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<select class=\"form-control\" id=\"" + this.id + "\" name=\"" + this.name + "\">\n";
        html    += "\t\t<option value=\"Yes\" " + (this.data?'selected':'') + ">Yes</option>\n";
        html    += "\t\t<option value=\"\" " + (this.data?'':'selected') + ">No</option>\n";
        html    += "\t\t</select>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.color.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<input class=\"form-control jscolor\" id=\"" + this.id + "\" name=\"" + this.name + "\" type=\"text\" value=\"" + this.data + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.gradient.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "_1\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-3 col-md-3\">\n";
        html    += "\t\t<input class=\"form-control jscolor\" id=\"" + this.id + "_1\" name=\"" + this.name + "[0]\" type=\"text\" value=\"" + this.data[0] + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "\t<div class=\"col-lg-3 col-md-3\">\n";
        html    += "\t\t<input class=\"form-control jscolor\" id=\"" + this.id + "_2\" name=\"" + this.name + "[1]\" type=\"text\" value=\"" + this.data[1] + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.date.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "\" name=\"" + this.name + "\" data-plugin-datepicker type=\"text\" value=\"" + this.data + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.email.prototype.render      = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "\" name=\"" + this.name + "\" type=\"email\" value=\"" + this.data + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.checkbox.prototype.render    = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\"></label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t<div class=\"checkbox-custom checkbox-default\">\n";
        html    += "\t\t<input id=\"" + this.id + "\" name=\"" + this.name + "\" type=\"checkbox\" value=\"" + this.config.value + "\" " + (this.config.required?'required="true"':'') + " " + (this.data === this.config.value?'checked="true"':'') + "/>\n";
        html    += "\t<label id=\"" + this.label_id + "\" for=\"" + this.id + "\">\n";
        html    += this.config.name + "\n";
        html    += "\t\t</label>\n";
        html    += "\t</div>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.checkbox.prototype.bind      = function() {
        $('#' + this.id).change(function(){
            var value   = this.checked?$(this).val():'';
            var control = sMedia.Configuration.control_space[$(this).attr('name')];
            if(control.config.conditions) {
                for(var k in control.config.conditions) {
                    for(var i in control.config.conditions[k]) {
                        if(value === k) {
                            sMedia.Configuration.control_space[control.config.conditions[k][i]].show();
                        } else {
                            sMedia.Configuration.control_space[control.config.conditions[k][i]].hide();
                        }
                    }
                }
            }
        });
        $('#' + this.id).change();
    };
    
    sMedia.Configuration.Types.checklist.prototype.render    = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        for(var v in this.config.options) {
            html    += "\t<div class=\"checkbox-custom checkbox-default\">\n";
            html    += "\t\t<input id=\"" + this.id + "_" + v + "\" name=\"" + this.name + "[]\" type=\"checkbox\" value=\"" + v + "\" " + (this.config.required?'required="true"':'') + " " + ((this.data && this.data.indexOf(v) >= 0)?'checked="true"':'') + "/>\n";
            html    += "\t<label id=\"" + this.label_id + "_" + v + "\" for=\"" + this.id + "_" + v + "\">\n";
            html    += this.config.options[v] + "\n";
            html    += "\t\t</label>\n";
            html    += "\t</div>\n";
        }
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.radio.prototype.render    = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        for(var v in this.config.options) {
            html    += "\t<div class=\"radio-custom radio-default\">\n";
            html    += "\t\t<input id=\"" + this.id + "_" + v + "\" name=\"" + this.name + "\" type=\"radio\" value=\"" + v + "\" " + (this.config.required?'required="true"':'') + " " + ((this.data === v)?'checked="true"':'') + "/>\n";
            html    += "\t<label id=\"" + this.label_id + "_" + v + "\" for=\"" + this.id + "_" + v + "\">\n";
            html    += this.config.options[v] + "\n";
            html    += "\t\t</label>\n";
            html    += "\t</div>\n";
        }
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.dropdown.prototype.render    = function() {
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-6 col-md-6\">\n";
        html    += "\t\t<select class=\"form-control\" data-plugin-multiselect data-plugin-options='{ \"maxHeight\": 200 }' id=\"" + this.id + "\" " + (this.config.required?'required="true"':'') + ">\n";
        for(var v in this.config.options) {
            html    += "\t<option value=\"" + v + "\" " + ((this.data === v)?'selected':'') + ">" + this.config.options[v] + "</option>\n";
        }
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
    
    sMedia.Configuration.Types.textpair.prototype.render   = function() {
        if(!this.data) this.data = ['', ''];
        var html = "<div class=\"form-group row\" id=\"" + this.container_id + "\">\n";
        html    += "\t<label id=\"" + this.label_id + "\" class=\"col-lg-2 col-md-4 control-label text-lg-right pt-2\" for=\"" + this.id + "_1\">" + this.config.name + (this.config.required?' <span class="required">*</span>':'') + "</label>\n";
        html    += "\t<div class=\"col-lg-3 col-md-3\">\n";
        html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "_1\" name=\"" + this.name + "[0]\" type=\"text\" value=\"" + this.data[0] + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "\t<div class=\"col-lg-3 col-md-3\">\n";
        html    += "\t\t<input class=\"form-control\" id=\"" + this.id + "_2\" name=\"" + this.name + "[1]\" type=\"text\" value=\"" + this.data[1] + "\" " + (this.config.required?'required="true"':'') + "/>\n";
        html    += "\t</div>\n";
        html    += "</div>\n";
        return html;
    };
}