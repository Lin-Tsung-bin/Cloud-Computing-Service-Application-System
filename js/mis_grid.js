/**
 * 製作kendo query
 * @param query_obj:查詢按鈕的div
 * @param grid_obj:查詢要操作的grid
 * @param query_column:查詢欄位設定 
 */
function show_query(query_obj,query_column,show_dialog){
	//下拉式選單欄位設定
	var dropdown_column=new Array();
	var default_column=new Array();                 
	var cnt=0;

	var query_sample_str="<div class='one_query'><div style='width:85%;float:left'>";
	query_sample_str+="<div class='col-md-4'><select name='item[]' id='item[]' class='item sele form-control'></select></div>";
	query_sample_str+="<div class='col-md-4'><select  name='type[]' id='type[]' class='type sele form-control'></select></div>";
	query_sample_str+="<div class='col-md-4 value_area'><input type='text' id='value[]' name='value[]' class='value form-control '></input></div>";
	query_sample_str+="</div><div style='width:5%;float:left;padding:5px'><input type='button' class='del_queryset btn btn-danger' value='X' /></div>";	
	query_sample_str+="</div></div>";
	
	
	var query_div_str="<div id='query_area'  style='display:none' >";
	query_div_str+="<div class='open_query'>隱藏查詢條件設定▲</div>";
	query_div_str+="<form id='query_form'>";
	
	query_div_str+="<div id='query_items'></div>";
	
	
	query_div_str+="</div></form>";
	query_div_str+="<div style='clear:both' id='query_btn_area'>";
	query_div_str+="<div style='padding-left:10px'><input class='send_query query_button ' type='button' value='查詢' />";
	query_div_str+="<input class='reset_query query_button ' type='button' value='清除' /></div>";	
	query_div_str+="</div>";	
	query_obj.html(query_div_str);

	var self_send_query=$(query_obj).find(".send_query");
	var self_cancel_query=$(query_obj).find(".reset_query");	
	var self_query_items=$(query_obj).find("#query_items");
	var self_query_area=$(query_obj).find("#query_area");
	var self_query_button=$(query_obj).find("#query_button");
	var type_option=[
					{'title':'相等(=)','field':'equal'},
					{'title':'不相等','field':'not_equal'},
					{'title':'相似(like)','field':'like'},
					{'title':'包含(in)','field':'in'},
					{'title':'大於(>)','field':'greater'},
					{'title':'小於(<)','field':'less'},
					{'title':'大於等於(>=)','field':'greater_equal'},
					{'title':'小於等於(<=)','field':'less_equal'},
					];

	for(var i in query_column){		
		dropdown_column[cnt]={};		
		dropdown_column[cnt].field=i;
		dropdown_column[cnt].title=query_column[i].title;
		cnt++;
	}
	
	//查詢預設值
	var cnt=0;
	
	for(var i in query_column){		
		if(query_column[i].defaultval!=undefined){
			for(var j in query_column[i].defaultval){
				default_column[cnt]={};		
				default_column[cnt].item=i;
				default_column[cnt].type=query_column[i].defaultval[j].type;
				default_column[cnt].value=query_column[i].defaultval[j].value;
				cnt++;
			}
			
		}
	}
	self_query_area.show();
	// 開查詢視窗
	if(show_dialog=='Y'){
		//開對話框			
		form_dialog=self_query_area.dialog({
        	'autoOpen':true,
        	'width':"600",
        	'height':"300",
        	'modal': true,
        	'title':"資料查詢"        	
        });	
	}
	//設定初始查詢
	if(self_query_items.children().length == 0){
		if(!default_column){
			add_queryitem();
		}else{
			for(var i in default_column){
				add_queryitem(default_column[i]);
			}
			add_queryitem();
		}
	}	
	//開window
	self_query_area.show();
	
	
	//查詢清除
	self_cancel_query.on("click", function(e){
		self_query_items.html('');
		add_queryitem();
	});
	
	//新增項目
	function add_queryitem(default_query){
	

		if(self_query_items.children().length == 0){
			self_query_items.append(query_sample_str);
		}else{
			self_query_items.append(query_sample_str);
		}
		
		//預設值
		var default_item='';
		var default_type='equal';
		var default_value='';
		if(default_query!=undefined){
			default_item=default_query.item;
			default_type=default_query.type;
			default_value=default_query.value;
		}
	
		
		var last_div=$(self_query_items).find("div.one_query:last");
		var item_str="<option value=''>--請選填查詢項目--</option>";	
		for(var i in dropdown_column){
			if(dropdown_column[i].field==default_item){
				item_str+="<option value='"+dropdown_column[i].field+"' selected>"+dropdown_column[i].title+"</option>";
			}else{
				item_str+="<option value='"+dropdown_column[i].field+"'>"+dropdown_column[i].title+"</option>";
			}
		}
		
		$(last_div).find(".item").html(item_str);
		
		
		$(last_div).find(".item").change( function(e) {
		    	var now_div=$(this).parent().parent();
			    var value = $(this).val();	
			 
		 	
			    //沒有選擇項目時不可以填後面的值
				if(value==''){									
					$(now_div).find('.value_area').html("<input type='text' id='value[]' name='value[]' class='value form-control' ></input>");
					$(now_div).find(".value").attr('readonly',true);
					$(now_div).find(".value").val('請先挑選查詢項目');
					$(now_div).find(".value").css('background-color','#f0f8ff');
				}else{
					
				 	//決定可以使用的查詢項(type)				 	 
				 	var allowtype=query_column[value].allowtype;
				 	if(allowtype!=undefined){
				 		var type_str="";
				 		for(var i in type_option){
				 			//因ie7 不能用indexOf 寫法修正			 			
				 			if($.inArray(type_option[i].field,allowtype )!=-1){				 						 			
				 				//關係		
								if(type_option[i].field==default_type){
									type_str+="<option value='"+type_option[i].field+"' selected>"+type_option[i].title+"</option>";
								}else{
									type_str+="<option value='"+type_option[i].field+"'>"+type_option[i].title+"</option>";
								}								
														
				 			}			 			
				 		}
				 		$(now_div).find(".type").html(type_str);
				 	}else{
				 		
						//關係
						var type_str="";
						for(var i in type_option){
							if(type_option[i].field==default_type){
								type_str+="<option value='"+type_option[i].field+"' selected>"+type_option[i].title+"</option>";
							}else{
								type_str+="<option value='"+type_option[i].field+"'>"+type_option[i].title+"</option>";
							}
						
						}
						

						$(last_div).find(".type").html(type_str);				 		
				 	}
				 	
				 	
		    		var sele_item_src=query_column[value].querySource;   	
		    		var sele_item_qut=query_column[value].queryType;   	
		    		
		    		if(sele_item_src!=undefined){
		    			if(sele_item_qut=='dropdownlist'){		    				
			    			var key_val="<select  id='value[]' name='value[]' class='value form-control' ></select>";

			   
			    			$(now_div).find(".value_area").html(key_val);
			    			var value_str="<option value=''>--請選填查詢值--</option>";
			    			for(var i in sele_item_src){
			    				value_str+="<option value='"+sele_item_src[i].value+"'>"+sele_item_src[i].name+"</option>";
			    			}

			    			$(now_div).find(".value").html(value_str);
			    			$(now_div).find(".value").change(function(e) {
		    					var pa_div=$(this).parent('div');							
		    					check_input(pa_div);

			    			});

					   	}
					   	
		    		}else{

		    			var key_val="<input type='text' id='value[]' name='value[]' class='value form-control' ></input>";
		    			$(now_div).find(".value_area").html(key_val);
		    		
		    			$(now_div).find('.value').keyup(function(){
		    				check_input($(this).parent('div'));
											
						});
	
		    		
		    		}
		    	}
	   		 
		}).change();
		
		//查詢值
		
		//給預設值
		if(default_value!=''){
			$(last_div).find(".value").val(default_value);
		}else{
			$(last_div).find(".value").attr('readonly',true);
			$(last_div).find(".value").val('請先挑選查詢項目');
			$(last_div).find(".value").css('background-color','#DDDDDD');
			
			//給預設關係
			var type_str="";
			for(var i in type_option){
				type_str+="<option value='"+type_option[i].field+"'>"+type_option[i].title+"</option>";
			}
			$(last_div).find(".type").html(type_str);
		}

		$(last_div).find(".del_queryset").click(function(){
			
			$parent=$(this).parent().parent();
			$parent.remove();
			if($("#query_items").children().length == 0){
				add_queryitem();
			}	
		});
	
		
		
		
	}
	//輸入檢查
	function check_input(obj){

		//(1)檢查是否為最後一個，若是加一筆	
		var now_div=$(obj).parent().parent();
		var now_item=$(now_div).find('.item');
		var now_value=$(now_div).find('.value');
	   	if ($(now_div).is(':last-child')){
	   		
	   	 	add_queryitem();
	   	 	
	   	}
	   	
	   	//(2)檢查是否有需要轉大小寫
	   
		var sele_item=($(now_div).find('.item').find(":selected").val());
		if(sele_item!=undefined){	
			
			if(query_column[sele_item].textcase!=undefined){
				if(query_column[sele_item].textcase=='toUpperCase'){
					$(now_value).val($(now_value).val().toUpperCase());
				}else if(query_column[sele_item].textcase=='toLowerCase'){
					$(now_value).val($(now_value).val().toLowerCase());
				}
			}
		}
	
	}
	//
	$(query_obj).find(".open_query").click(function(){		
		if($(query_obj).find("#query_form").is(":visible")){
			$(this).html('展開查詢條件設定▼');
			$(query_obj).find("#query_form").hide();
			$(query_obj).find("#query_btn_area").hide();
			
		}else{
			$(this).html('隱藏查詢條件設定▲');
			$(query_obj).find("#query_form").show();
			$(query_obj).find("#query_btn_area").show();
		}
		
	});
	return self_query_area;

}
/*
 * grid form維護畫面
 * 以grid目前點擊的資料當做key值去查db
 */
function load_data(form,grid,mode,baseUrl){    
	
	 var original_data=new Object();
	 var query_str="";    	
	 if(grid.find('.nowsele').length!=0 || mode=='add'){
		 if(mode!='add'){
			 grid.find('.nowsele [data_type=key]').each(function(){
			 	query_str+="&"+$(this).attr('data_field')+"="+$(this).html();
			 	        	
		     });
		 }
	
		 
	     query_str+="&mode="+mode;
		 $.ajax({
	        type: "POST",
	        url: baseUrl + "&m=get",
	        data:query_str,
	        async:false,    
	        dataType:'json',   
	        success: function(form_data){	

				for(var i in form_data ){
								
					var editable=form_data[i].editable;	
					var name=form_data[i].name;	
					var value=(form_data[i].value);					
					if(value!=null){
						value=value.replace(/(^\s*)|(\s*$)/g, "" );
					}
					//設定初始值
					original_data[name+"_original"]=value;
					
					
					var form_element=form.find("[name='"+name+"']");
				    var input_obj=form.find("input[name='"+name+"']");
				    var select_obj=form.find("select[name='"+name+"']");
				    var textarea_obj=form.find("textarea[name='"+name+"']");				
				    var input_tagName = form_element.prop("nodeName");
				    var fieldType =null;
				  
				    if(select_obj.length==0){				    	
				    	if(textarea_obj.length!=0){
				    		fieldType="textarea";
				    	}else{
				    		fieldType = input_obj.attr("type");
				    	}	
				    }else{
				    	fieldType="select";
				    }

					var show_obj=form.find("div[name='"+name+"']");
					
	 				var show_fieldType = show_obj.attr("type");
			        switch(fieldType){
	                    case "radio":
	                    case "checkbox":                           
	                        input_obj.filter("[value='" + value + "']").prop('checked', true);
	                        break;
	                    case "select":
	                    	select_obj.val(value);
	                    case "file":
	                        break; 
	                    case "textarea":
	                         textarea_obj.html(value);
	                         break;             
	                    default:
	                        input_obj.val(value);
	                        break;
	                }	
					
					if(editable){	
						show_obj.text("");
						show_obj.hide();
						input_obj.show();
						input_obj.attr('disabled',false);
						select_obj.val(value);
						select_obj.show();
						
						textarea_obj.val(value);
						//textarea_obj.html(value)
						textarea_obj.show();						
					}else{
						
						
						if(fieldType=='text'){
							input_obj.hide();
							show_obj.show();
							show_obj.text(value);
						}else if(fieldType=='select'){
							select_obj.hide();
							show_obj.show();
							//取option value	
							
							var option_text=$(select_obj).find("option[value='"+value+"']").text();						
							show_obj.text(option_text);
						}else if(fieldType=='textarea'){
							textarea_obj.hide();
							show_obj.show();
							show_obj.html(textarea_obj.html());
							
						}else{
							show_obj.hide();
							textarea_obj.show();
							input_obj.attr('disabled',true);
							
						}
						
					}	
							
						
				}
				
				
	   	    },
	  	    error:function(XMLHttpRequest, textStatus, errorThrown){
		        alert("抱歉，資料處理失敗!");		
	        }
	    });
	}else{
		if(mode!='add'){
			alert('請挑選一筆資料!');
		}	
	}
    return original_data;
}
/*
 * 單一form維護畫面，以key值去查db
 */
function form_load_data(form,key,mode,baseUrl){    
	 var original_data=new Object();
	 var query_str=$.param(key);    	

	     query_str+="&mode="+mode;
		 $.ajax({
	        type: "POST",
	        url: baseUrl + "&m=get",
	        data:query_str,
	        async:false,    
	        dataType:'json',   
	        success: function(form_data){	

				for(var i in form_data ){
								
					var editable=form_data[i].editable;	
					var name=form_data[i].name;	
					var value=(form_data[i].value);					
					if(value!=null){
						value=value.replace(/(^\s*)|(\s*$)/g, "" );
					}
					//設定初始值
					original_data[name+"_original"]=value;
					
					
					var form_element=form.find("[name='"+name+"']");
				    var input_obj=form.find("input[name='"+name+"']");
				    var select_obj=form.find("select[name='"+name+"']");
				    var textarea_obj=form.find("textarea[name='"+name+"']");				
				    var input_tagName = form_element.prop("nodeName");
				    var fieldType =null;
				  
				    if(select_obj.length==0){				    	
				    	if(textarea_obj.length!=0){
				    		fieldType="textarea";
				    	}else{
				    		fieldType = input_obj.attr("type");
				    	}	
				    }else{
				    	fieldType="select";
				    }

					var show_obj=form.find("div[name='"+name+"']");
					
	 				var show_fieldType = show_obj.attr("type");
			        switch(fieldType){
	                    case "radio":
	                    case "checkbox":                           
	                        input_obj.filter("[value='" + value + "']").prop('checked', true);
	                        break;
	                    case "select":
	                    	select_obj.val(value);
	                    case "file":
	                        break; 
	                    case "textarea":
	                         textarea_obj.html(value);
	                         break;             
	                    default:
	                        input_obj.val(value);
	                        break;
	                }	
					
					if(editable){	
						show_obj.text("");
						show_obj.hide();
						input_obj.show();
						input_obj.attr('disabled',false);
						select_obj.val(value);
						select_obj.show();
						
						textarea_obj.val(value);
						textarea_obj.show();						
					}else{
						
						
						if(fieldType=='text'){
							input_obj.hide();
							show_obj.show();
							show_obj.text(value);
						}else if(fieldType=='select'){
							select_obj.hide();
							show_obj.show();
							//取option value	
							
							var option_text=$(select_obj).find("option[value='"+value+"']").text();						
							show_obj.text(option_text);
						}else if(fieldType=='textarea'){
							textarea_obj.hide();
							show_obj.show();
							show_obj.html(textarea_obj.html());
							
						}else{
							show_obj.hide();
							textarea_obj.show();
							input_obj.attr('disabled',true);
							
						}
						
					}	
							
						
				}
	   	    },
	  	    error:function(XMLHttpRequest, textStatus, errorThrown){
		        alert("抱歉，資料處理失敗!");		
	        }
	    });

    return original_data;
}
/*
 * 將form原本欄位加上"_original"
 */
function get_form_ori(form_original){
	var s = {};
	$.map(form_original, function(v, k) {
		var k1 = k.replace(/(\[\]*$)/g, "");			
		s[k1 + "_original"] = v;
	});		
	return s;
}
/*
 * 控制表單元素show hide
 * @param form_column:欄位設定
 * @param form_div   :要操作的FORM
 * @param status     :狀態(new|modify|read)
 */
function show_control(form_column,form_div,status){	
	for(var i in form_column ){				
		var name=form_column[i].name;
		var editable;  	                      
	    if(status=='new'){    			
			editable=(form_column[i].editable).substr(0,1);
		}else if(status=='modify'){
			editable=(form_column[i].editable).substr(1,1);
		}else if(status=='read'){
			editable='0';
		}
		if(editable=='1'){	
			$(form_div).find("input[type='text'][name$='"+name+"']").show();			
			$(form_div).find("div[name$='"+name+"']").hide();
			$(form_div).find("input[type='radio'][name$='"+name+"']").attr('disabled',false);
		}else{
			$(form_div).find("input[type='text'][name$='"+name+"']").hide();
			$(form_div).find("div[name$='"+name+"']").show();
			$(form_div).find("input[type='radio'][name$='"+name+"']").attr('disabled',true);
			
		}			
	}

}

