// JavaScript Document

;(function(app, $) {
	app.config = {
		init : function() {
			$(".color").colorpicker();
			app.config.set_conf();
			app.config.choose_area();
			app.config.quick_search();
			app.config.selected_area();
			app.config.search_article();
			app.config.add_adsense_group();
			app.config.del_adsense_group();
			$('#info-toggle-button').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
			$('#is_open_checkin').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
			$('#is_open_comment_integral').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
		},
		set_conf : function() {
			var $this = $("form[name='theForm']");
			var option = {
				submitHandler:function(){
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data){
							$('fieldset .fileupload').each(function(i){
								if($(this).find("img").attr("src") || $(this).children().find("a").attr("href")){
									$(this).children("a:last-child").attr("data-removefile","true");
								} 
							});
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		choose_area : function() {
			$('.select_hot_city').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					val = $this.attr('data-val'),
					url = $this.parent().attr('data-url'),
					$next = $('.' + $this.parent().attr('data-next'));
					$next_attr = $this.parent().attr('data-next');
				/* 如果是县乡级别的，不触发后续操作 */
				if ($this.parent().hasClass('selDistricts')) {
					$this.siblings().removeClass('disabled');
					if (val != 0)$this.addClass('disabled');
					return;
				}
				/* 如果是0的选项，则后续参数也设置为0 */
				if (val == 0) {
					var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>没有可选择地区名称…</span></li>');
					$next.html($tmp);
					$tmp.trigger('click');
					return;
				}
				/* 请求参数 */
				$.get(url, {parent : val}, function(data) {
					$this.siblings().removeClass('disabled');
					$this.addClass('disabled');
					var html = '';
					/* 如果有返回参数，则赋值并触发下一级别的选中 */
					if (data.regions) {
						for (var i = 0; i <= data.regions.length - 1; i++) {
							html += '<li class="ms-elem-selectable select_hot_city" data-val="' + data.regions[i].region_id + '"><span>' + data.regions[i].region_name + '</span>';
							if ($next_attr == 'selCities') {
								html += '<span class="edit-list"><a href="javascript:;">添加</a></span>';
							}
							html += '</li>';
						};
						
						$next.html(html);
						app.config.quick_search();
						$('.select_hot_city').unbind( "click" );
						$('.select_hot_city .edit-list a').unbind( "click" );
						app.config.choose_area();
						app.config.selected_area();
						$next.find('.select_hot_city').eq(0).trigger('click');
					/* 如果没有返回参数，则直接触发选中0的操作 */
					} else {
						var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>没有可选择地区名称…</span></li>');
						$next.html($tmp);
						$tmp.trigger('click');
						return;
					}
				}, 'json');
			});
		},
		quick_search : function() {
			var opt = {
					onAfter : function(){
						$('.ms-group').each(function(index) {
							$(this).find('.isShow').length ? $(this).css('display','block') : $(this).css('display','none');
						});
						return;
					},
					show: function () {
						this.style.display = "";
						$(this).addClass('isShow');
					},
					hide: function () {
						this.style.display = "none";
						$(this).removeClass('isShow');
					},
				};
			$('#selCountry').quicksearch($('.selCountry .ms-elem-selectable'), opt);
			$('#selProvinces').quicksearch($('.selProvinces .ms-elem-selectable'), opt);
			$('#selCities').quicksearch($('.selCities .ms-elem-selectable'), opt);
			$('#selDistricts').quicksearch($('.selDistricts .ms-elem-selectable'), opt);
		},
		selected_area : function() {
			$('.ms-elem-selectable .edit-list a').on('click', function(e) {
				e.preventDefault(); e.stopPropagation();
				var bool = true;
				var $this = $(this),
					$parent = $this.parents('li.ms-elem-selectable'),
					val = $parent.attr('data-val'),
					name = $parent.find('span').eq(0).text(),
					$tmp = $('<input type="checkbox" checked="checked" value="' + val + '" name="regions[]" /><span class="m_r10">' + name + '</span>');
				$('.selected_area div').each(function(i){
					if ($(this).find("input").val() == val) {
						var data = {
								message : "该地区已被选择！",
								state : "error",
						};
						ecjia.admin.showmessage(data);
						bool = false;
						return false;
					}
				}) ;
				if (bool) {
					$('.selected_area').append($tmp);
					$tmp.uniform();
				}
			});
		},
		search_article : function () {
			$('.article_search').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var keyword = $(this).siblings('.keywords').val();
				$.ajax({
					type : "POST",
					url : url,
					data : {artile: keyword},
					dataType: "json",
					success: function(data){
						app.config.artilce_list(data);
					}
				});
			});
		},
		artilce_list : function (data) {
			$('.artilce_list').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var opt = '<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>'
					$('.artilce_list').append(opt);
				};
			} else {
				$('.artilce_list').append('<option value="-1">未搜索到商品信息</option>');
			}
			
			$('.artilce_list').trigger("liszt:updated").trigger("change");
		},
		add_adsense_group : function() {
			$('.select_adsense_group li')
			.on('click', function() {
				var $this = $(this),
					tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="mobile_home_adsense_group[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>' );
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo( $( ".ms-selection .nav-list-content" ) );
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				})
				.find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},
		del_adsense_group : function() {
			$('.ms-elem-selection').each(function(index){
				var $this = $(this);
				$('.nav-list-ready li').each(function(i){
					if ($( ".nav-list-ready li" ).eq(i).attr('id') == 'position_id_' + $this.find('input').val()) {
						$( ".nav-list-ready li" ).eq(i).addClass('disabled');
					}
				});
			}); 
			
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$( ".nav-list-ready li" ).each(function(index) {
					if ($( ".nav-list-ready li" ).eq(index).attr('id') == 'position_id_' + $this.find('input').val()) {
						$( ".nav-list-ready li" ).eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			})
			.find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},
		
	}



})(ecjia.admin, jQuery);


// end
