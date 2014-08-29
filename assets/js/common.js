//定义一个公共的对象
var wdcrm={};
//为一个公共对象添加公共的方法
/*
 * @param object wd 公共对象
 * @param object $  jQuery对象
 */
(function(wd,$){

	//給表单隐藏域写入id值
	wd.set_id=function(idname,getid) {
		$('input[name="'+idname+'"]').val(getid);
		//$('#'+idname).val(getid);
		//console.log($('#'+idname));
	};
	/**
	 * 删除dom元素
	 * @param object 传递过来的对象	
	 * @param number 向上删除的层数
	 */
	wd.removeInput=function(obj,num){
		for (var i = 0; i < num; i++) {
			obj=obj.parentNode;
		}
		var son= obj;
		var father=son.parentNode;
		
		father.removeChild(son);
	};

	//时间戳--js时间对象处理-得到时间格式
	wd.timeaction = function (time){
		var today=new Date(parseInt(time)*1000);
		var h=today.getHours(),
			m=today.getMinutes();
		if(h<10){
			h = "0"+h;
		}	
		if(m<10){
			m = "0"+m;
		}
		return h+':'+m;
	};

	//去除左右字符串的空格
	wd.trim=function (s) {
		return this.trimRight(this.trimLeft(s)); 
	}

	//去除左字符串的空格
	wd.trimLeft = function (s) {
		if(s == null) {  
			return "";  
		}  
		var whitespace = new String(" \t\n\r");  
		var str = new String(s);  
		if (whitespace.indexOf(str.charAt(0)) != -1) {  
			var j=0, i = str.length;  
			while (j < i && whitespace.indexOf(str.charAt(j)) != -1){  
			j++;  
			}  
			str = str.substring(j, i);  
		}  
		return str;  
	}

	//去除右字符串的空格
	wd.trimRight = function (s) {
		if(s == null) return "";  
		var whitespace = new String(" \t\n\r");  
		var str = new String(s);  
		if (whitespace.indexOf(str.charAt(str.length-1)) != -1){  
		var i = str.length - 1;  
		while (i >= 0 && whitespace.indexOf(str.charAt(i)) != -1){  
		i--;  
		}  
		str = str.substring(0, i+1);  
		}  
		return str;  
	}

	wd.isCheck = function (str,type) {

		str = this.trim(str);

		if(type == 'qq'){
			
			var pattern=/^\d+$/;
			var flag = pattern.test(str);
			if(!flag){
				return false;
			}else{
				return true;
			}

		}else if(type == 'phones'){

			var prefix = /^1\d{10}$/;
			return prefix.test(str); 

		}else if(type == 'email'){

			var pattern=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			var flag = pattern.test(str);
			console.log(flag);
			if(!flag){
				return false;
			}else{
				return true;
			}
		}
	};
	/**
	 *	字符串解析
	 */
	 wd.parse_str=function(str, array) {
		  //       discuss at: http://phpjs.org/functions/parse_str/
		  //      original by: Cagri Ekin
		  //      improved by: Michael White (http://getsprink.com)
		  //      improved by: Jack
		  //      improved by: Brett Zamir (http://brett-zamir.me)
		  //      bugfixed by: Onno Marsman
		  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
		  //      bugfixed by: stag019
		  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
		  //      bugfixed by: MIO_KODUKI (http://mio-koduki.blogspot.com/)
		  // reimplemented by: stag019
		  //         input by: Dreamer
		  //         input by: Zaide (http://zaidesthings.com/)
		  //         input by: David Pesta (http://davidpesta.com/)
		  //         input by: jeicquest
		  //             note: When no argument is specified, will put variables in global scope.
		  //             note: When a particular argument has been passed, and the returned value is different parse_str of PHP. For example, a=b=c&d====c
		  //             test: skip
		  //        example 1: var arr = {};
		  //        example 1: parse_str('first=foo&second=bar', arr);
		  //        example 1: $result = arr
		  //        returns 1: { first: 'foo', second: 'bar' }
		  //        example 2: var arr = {};
		  //        example 2: parse_str('str_a=Jack+and+Jill+didn%27t+see+the+well.', arr);
		  //        example 2: $result = arr
		  //        returns 2: { str_a: "Jack and Jill didn't see the well." }
		  //        example 3: var abc = {3:'a'};
		  //        example 3: parse_str('abc[a][b]["c"]=def&abc[q]=t+5');
		  //        returns 3: {"3":"a","a":{"b":{"c":"def"}},"q":"t 5"}

		  var strArr = String(str)
			.replace(/^&/, '')
			.replace(/&$/, '')
			.split('&'),
			sal = strArr.length,
			i, j, ct, p, lastObj, obj, lastIter, undef, chr, tmp, key, value,
			postLeftBracketPos, keys, keysLen,
			fixStr = function(str) {
			  return decodeURIComponent(str.replace(/\+/g, '%20'));
			};

		  if (!array) {
			array = this.window;
		  }

		  for (i = 0; i < sal; i++) {
			tmp = strArr[i].split('=');
			key = fixStr(tmp[0]);
			value = (tmp.length < 2) ? '' : fixStr(tmp[1]);

			while (key.charAt(0) === ' ') {
			  key = key.slice(1);
			}
			if (key.indexOf('\x00') > -1) {
			  key = key.slice(0, key.indexOf('\x00'));
			}
			if (key && key.charAt(0) !== '[') {
			  keys = [];
			  postLeftBracketPos = 0;
			  for (j = 0; j < key.length; j++) {
				if (key.charAt(j) === '[' && !postLeftBracketPos) {
				  postLeftBracketPos = j + 1;
				} else if (key.charAt(j) === ']') {
				  if (postLeftBracketPos) {
					if (!keys.length) {
					  keys.push(key.slice(0, postLeftBracketPos - 1));
					}
					keys.push(key.substr(postLeftBracketPos, j - postLeftBracketPos));
					postLeftBracketPos = 0;
					if (key.charAt(j + 1) !== '[') {
					  break;
					}
				  }
				}
			  }
			  if (!keys.length) {
				keys = [key];
			  }
			  for (j = 0; j < keys[0].length; j++) {
				chr = keys[0].charAt(j);
				if (chr === ' ' || chr === '.' || chr === '[') {
				  keys[0] = keys[0].substr(0, j) + '_' + keys[0].substr(j + 1);
				}
				if (chr === '[') {
				  break;
				}
			  }

			  obj = array;
			  for (j = 0, keysLen = keys.length; j < keysLen; j++) {
				key = keys[j].replace(/^['"]/, '')
				  .replace(/['"]$/, '');
				lastIter = j !== keys.length - 1;
				lastObj = obj;
				if ((key !== '' && key !== ' ') || j === 0) {
				  if (obj[key] === undef) {
					obj[key] = {};
				  }
				  obj = obj[key];
				} else { // To insert new dimension
				  ct = -1;
				  for (p in obj) {
					if (obj.hasOwnProperty(p)) {
					  if (+p > ct && p.match(/^\d+$/g)) {
						ct = +p;
					  }
					}
				  }
				  key = ct + 1;
				}
			  }
			  lastObj[key] = value;
			}
		  }
		};

	/**
	 * 检测是否存在于数组中
	 */
	wd.in_array= function(needle, haystack, argStrict) {
					  //  discuss at: http://phpjs.org/functions/in_array/
					  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
					  // improved by: vlado houba
					  // improved by: Jonas Sciangula Street (Joni2Back)
					  //    input by: Billy
					  // bugfixed by: Brett Zamir (http://brett-zamir.me)
					  //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
					  //   returns 1: true
					  //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
					  //   returns 2: false
					  //   example 3: in_array(1, ['1', '2', '3']);
					  //   example 3: in_array(1, ['1', '2', '3'], false);
					  //   returns 3: true
					  //   returns 3: true
					  //   example 4: in_array(1, ['1', '2', '3'], true);
					  //   returns 4: false

					  var key = '',
					    strict = !! argStrict;

					  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
					  //in just one for, in order to improve the performance 
					  //deciding wich type of comparation will do before walk array
					  if (strict) {
					    for (key in haystack) {
					      if (haystack[key] === needle) {
					        return true;
					      }
					    }
					  } else {
					    for (key in haystack) {
					      if (haystack[key] == needle) {
					        return true;
					      }
					    }
					  }

					  return false;
				};

	/**
	 * 时间格式转换为时间戳
	 */
	wd.strtotime = function(text, now) {
		  //  discuss at: http://phpjs.org/functions/strtotime/
		  //     version: 1109.2016
		  // original by: Caio Ariede (http://caioariede.com)
		  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // improved by: Caio Ariede (http://caioariede.com)
		  // improved by: A. Matías Quezada (http://amatiasq.com)
		  // improved by: preuter
		  // improved by: Brett Zamir (http://brett-zamir.me)
		  // improved by: Mirko Faber
		  //    input by: David
		  // bugfixed by: Wagner B. Soares
		  // bugfixed by: Artur Tchernychev
		  //        note: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
		  //   example 1: strtotime('+1 day', 1129633200);
		  //   returns 1: 1129719600
		  //   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
		  //   returns 2: 1130425202
		  //   example 3: strtotime('last month', 1129633200);
		  //   returns 3: 1127041200
		  //   example 4: strtotime('2009-05-04 08:30:00 GMT');
		  //   returns 4: 1241425800

		  var parsed, match, today, year, date, days, ranges, len, times, regex, i, fail = false;

		  if (!text) {
		    return fail;
		  }

		  // Unecessary spaces
		  text = text.replace(/^\s+|\s+$/g, '')
		    .replace(/\s{2,}/g, ' ')
		    .replace(/[\t\r\n]/g, '')
		    .toLowerCase();

		  // in contrast to php, js Date.parse function interprets:
		  // dates given as yyyy-mm-dd as in timezone: UTC,
		  // dates with "." or "-" as MDY instead of DMY
		  // dates with two-digit years differently
		  // etc...etc...
		  // ...therefore we manually parse lots of common date formats
		  match = text.match(
		    /^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/);

		  if (match && match[2] === match[4]) {
		    if (match[1] > 1901) {
		      switch (match[2]) {
		        case '-':
		          { // YYYY-M-D
		            if (match[3] > 12 || match[5] > 31) {
		              return fail;
		            }

		            return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		        case '.':
		          { // YYYY.M.D is not parsed by strtotime()
		            return fail;
		          }
		        case '/':
		          { // YYYY/M/D
		            if (match[3] > 12 || match[5] > 31) {
		              return fail;
		            }

		            return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		      }
		    } else if (match[5] > 1901) {
		      switch (match[2]) {
		        case '-':
		          { // D-M-YYYY
		            if (match[3] > 12 || match[1] > 31) {
		              return fail;
		            }

		            return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		        case '.':
		          { // D.M.YYYY
		            if (match[3] > 12 || match[1] > 31) {
		              return fail;
		            }

		            return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		        case '/':
		          { // M/D/YYYY
		            if (match[1] > 12 || match[3] > 31) {
		              return fail;
		            }

		            return new Date(match[5], parseInt(match[1], 10) - 1, match[3],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		      }
		    } else {
		      switch (match[2]) {
		        case '-':
		          { // YY-M-D
		            if (match[3] > 12 || match[5] > 31 || (match[1] < 70 && match[1] > 38)) {
		              return fail;
		            }

		            year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
		            return new Date(year, parseInt(match[3], 10) - 1, match[5],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		        case '.':
		          { // D.M.YY or H.MM.SS
		            if (match[5] >= 70) { // D.M.YY
		              if (match[3] > 12 || match[1] > 31) {
		                return fail;
		              }

		              return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		                match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		            }
		            if (match[5] < 60 && !match[6]) { // H.MM.SS
		              if (match[1] > 23 || match[3] > 59) {
		                return fail;
		              }

		              today = new Date();
		              return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
		                match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
		            }

		            return fail; // invalid format, cannot be parsed
		          }
		        case '/':
		          { // M/D/YY
		            if (match[1] > 12 || match[3] > 31 || (match[5] < 70 && match[5] > 38)) {
		              return fail;
		            }

		            year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
		            return new Date(year, parseInt(match[1], 10) - 1, match[3],
		              match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
		          }
		        case ':':
		          { // HH:MM:SS
		            if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
		              return fail;
		            }

		            today = new Date();
		            return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
		              match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
		          }
		      }
		    }
		  }

		  // other formats and "now" should be parsed by Date.parse()
		  if (text === 'now') {
		    return now === null || isNaN(now) ? new Date()
		      .getTime() / 1000 | 0 : now | 0;
		  }
		  if (!isNaN(parsed = Date.parse(text))) {
		    return parsed / 1000 | 0;
		  }

		  date = now ? new Date(now * 1000) : new Date();
		  days = {
		    'sun': 0,
		    'mon': 1,
		    'tue': 2,
		    'wed': 3,
		    'thu': 4,
		    'fri': 5,
		    'sat': 6
		  };
		  ranges = {
		    'yea': 'FullYear',
		    'mon': 'Month',
		    'day': 'Date',
		    'hou': 'Hours',
		    'min': 'Minutes',
		    'sec': 'Seconds'
		  };

		  function lastNext(type, range, modifier) {
		    var diff, day = days[range];

		    if (typeof day !== 'undefined') {
		      diff = day - date.getDay();

		      if (diff === 0) {
		        diff = 7 * modifier;
		      } else if (diff > 0 && type === 'last') {
		        diff -= 7;
		      } else if (diff < 0 && type === 'next') {
		        diff += 7;
		      }

		      date.setDate(date.getDate() + diff);
		    }
		  }

		  function process(val) {
		    var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
		      type = splt[0],
		      range = splt[1].substring(0, 3),
		      typeIsNumber = /\d+/.test(type),
		      ago = splt[2] === 'ago',
		      num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

		    if (typeIsNumber) {
		      num *= parseInt(type, 10);
		    }

		    if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
		      return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
		    }

		    if (range === 'wee') {
		      return date.setDate(date.getDate() + (num * 7));
		    }

		    if (type === 'next' || type === 'last') {
		      lastNext(type, range, num);
		    } else if (!typeIsNumber) {
		      return false;
		    }

		    return true;
		  }

		  times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
		    '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
		    '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
		  regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

		  match = text.match(new RegExp(regex, 'gi'));
		  if (!match) {
		    return fail;
		  }

		  for (i = 0, len = match.length; i < len; i++) {
		    if (!process(match[i])) {
		      return fail;
		    }
		  }

		  // ECMAScript 5 only
		  // if (!match.every(process))
		  //    return false;

		  return (date.getTime() / 1000);
		}
		
})(wdcrm,jQuery);


/**
 *	chrome 桌面通知
 */
function notify(content){
		if (window.webkitNotifications) {
		if (window.webkitNotifications.checkPermission() == 0) {
			var notification_test = window.webkitNotifications.createNotification('/assets/images/message/message.jpg', '提醒', content);
			notification_test.display = function() {}
			notification_test.onerror = function() {}
			notification_test.onclose = function() {}
			notification_test.onclick = function() {this.cancel();}
			
			notification_test.replaceId = 'Meteoric';

			notification_test.show();
						
			
		} else {
			window.webkitNotifications.requestPermission(function(){notify('亲,您添加成功!');});
		}
	}
	

};

//页面侧边栏显示与否
jQuery(function($){
		var url= window.location.href;
		var num = url.match(/\?/g);   // 尝试匹配搜索字符串。
		if(num.length>1){
			var tmp=url.lastIndexOf('?');
		 		url=url.substr(0,tmp);
		}
		
		//左侧菜单选中状态
		$('.submenu').find('a').each(function(){

			var checked= $(this).attr('href');

			if (checked===url){

				//给父亲加样式
				$(this).parent().addClass('active');
				$(this).parent().parent().css('display','block');
				$(this).parent().parent().parent().css('display','open');
			};
		});

	var tmps;
	//三级菜单
	if(url.indexOf('consultant_channel_id')!=-1||url.indexOf('consultant_consultate_id')!=-1){
		if(url.indexOf('advisory/advisory')!=-1){
			tmps='咨询者管理';	
		}else if(url.indexOf('advisory/student')!=-1){
			tmps='学员管理';	
		}else if(url.indexOf('advisory/client')!=-1){
			tmps='客户管理';	
		}

		$('.menu-text').each(function(){
			if($.trim($(this).html())==tmps){
				$(this).parent().parent().addClass('open');
				$(this).parent().next().css('display','block');
			}
		});
	}
	

	//处理年份和月份和天数（联动菜单--js自定义对象）
	function DateSelector(selYear, selMonth, selDay)
	{
	    this.selYear = selYear;
	    this.selMonth = selMonth;
	    this.selDay = selDay;
	    this.selYear.Group = this;
	    this.selMonth.Group = this;
	    // 给年份、月份下拉菜单添加处理onchange事件的函数
	    if(window.document.all != null) // IE
	    {
	        this.selYear.attachEvent("onchange", DateSelector.Onchange);
	        this.selMonth.attachEvent("onchange", DateSelector.Onchange);
	    }
	    else // Firefox
	    {
	        this.selYear.addEventListener("change", DateSelector.Onchange, false);
	        this.selMonth.addEventListener("change", DateSelector.Onchange, false);
	    }

	    if(arguments.length == 4) // 如果传入参数个数为4，最后一个参数必须为Date对象
	        this.InitSelector(arguments[3].getFullYear(), arguments[3].getMonth() + 1, arguments[3].getDate());
	    else if(arguments.length == 6) // 如果传入参数个数为6，最后三个参数必须为初始的年月日数值
	        this.InitSelector(arguments[3], arguments[4], arguments[5]);
	    else // 默认使用当前日期
	    {
	        var dt = new Date();
	        this.InitSelector(dt.getFullYear(), dt.getMonth() + 1, dt.getDate());
	    }
	}

	// 增加一个最大年份的属性
	DateSelector.prototype.MinYear = 1900;

	// 增加一个最大年份的属性
	DateSelector.prototype.MaxYear = (new Date()).getFullYear();

	// 初始化年份
	DateSelector.prototype.InitYearSelect = function()
	{
	    // 循环添加OPION元素到年份select对象中
	    for(var i = this.MaxYear; i >= this.MinYear; i--)
	    {
	        // 新建一个OPTION对象
	        var op = window.document.createElement("OPTION");
	        
	        // 设置OPTION对象的值
	        op.value = i;
	        
	        // 设置OPTION对象的内容
	        op.innerHTML = i;
	        
	        // 添加到年份select对象
	        this.selYear.appendChild(op);
	    }
	}

	// 初始化月份
	DateSelector.prototype.InitMonthSelect = function()
	{
	    // 循环添加OPION元素到月份select对象中
	    for(var i = 1; i < 13; i++)
	    {
	        // 新建一个OPTION对象
	        var op = window.document.createElement("OPTION");
	        
	        // 设置OPTION对象的值
	        op.value = i;
	        
	        // 设置OPTION对象的内容
	        op.innerHTML = i;
	        
	        // 添加到月份select对象
	        this.selMonth.appendChild(op);
	    }
	}

	// 根据年份与月份获取当月的天数
	DateSelector.DaysInMonth = function(year, month)
	{
	    var date = new Date(year, month, 0);
	    return date.getDate();
	}

	// 初始化天数
	DateSelector.prototype.InitDaySelect = function()
	{
	    // 使用parseInt函数获取当前的年份和月份
	    var year = parseInt(this.selYear.value);
	    var month = parseInt(this.selMonth.value);
	    
	    // 获取当月的天数
	    var daysInMonth = DateSelector.DaysInMonth(year, month);
	    
	    // 清空原有的选项
	   // this.selDay.options.length = 0;
	    // 循环添加OPION元素到天数select对象中
	    for(var i = 1; i <= daysInMonth ; i++)
	    {
	        // 新建一个OPTION对象
	        var op = window.document.createElement("OPTION");
	        
	        // 设置OPTION对象的值
	        op.value = i;
	        
	        // 设置OPTION对象的内容
	        op.innerHTML = i;
	        
	        // 添加到天数select对象
	        //this.selDay.appendChild(op);
	    }
	}

	// 处理年份和月份onchange事件的方法，它获取事件来源对象（即selYear或selMonth）
	// 并调用它的Group对象（即DateSelector实例，请见构造函数）提供的InitDaySelect方法重新初始化天数
	// 参数e为event对象
	DateSelector.Onchange = function(e)
	{
	    var selector = window.document.all != null ? e.srcElement : e.target;
	    selector.Group.InitDaySelect();
	}

	// 根据参数初始化下拉菜单选项
	DateSelector.prototype.InitSelector = function(year, month, day)
	{
	    // 由于外部是可以调用这个方法，因此我们在这里也要将selYear和selMonth的选项清空掉
	    // 另外因为InitDaySelect方法已经有清空天数下拉菜单，因此这里就不用重复工作了
	    this.selYear.options.length = 0;
	    this.selMonth.options.length = 0;
	    
	    // 初始化年、月
	    this.InitYearSelect();
	    this.InitMonthSelect();
	    
	    // 设置年、月初始值
	    this.selYear.selectedIndex = this.MaxYear - year;
	    this.selMonth.selectedIndex = month - 1;
	    
	    // 初始化天数
	    this.InitDaySelect();
	    
	    // 设置天数初始值
	    //this.selDay.selectedIndex = day - 1;
	}
});




