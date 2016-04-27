// JavaScript Document

;(function(app, $) {

	app.mobile_manage = {
		info : function() {
			app.mobile_manage.submit();
			
			$('#info-toggle-button').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
			
		},
		submit : function() {
			var $this = $("form[name='theForm']");
			var option = {
					rules:{
						name : {
								required : true
						},
						client : {
							required : true
						},
						code : {
							required : true
						},
						bundleid : {
							required : true
						},
						appkey : {
							required : true
						},
						appsecret : {
							required : true
						},
						platform : {
							required : true
						},
					},
					messages:{
						name : {
								required : "请填写应用名称！" 
						},
						client : {
							required : "请选择应用client！" 
						},
						code : {
							required : "请填写应用code！" 
						},
						bundleid : {
							required : "请填写应用包名！" 
						},
						appkey : {
							required : "请填写AppKey！" 
						},
						appsecret : {
							required : "请填写AppSecret！" 
						},
						platform : {
							required : "请选择服务平台！" 
						},
					},
					submitHandler:function(){
						$this.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
	};



})(ecjia.admin, jQuery);


// end
