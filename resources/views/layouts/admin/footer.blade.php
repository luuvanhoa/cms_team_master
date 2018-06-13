	<div class="page-footer">
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<span class="txt-color-white">Loi Phat Copyright © 2015-2016</span>
			</div>

			<div class="col-xs-6 col-sm-6 text-right hidden-xs">
				<div class="txt-color-white inline-block">
					<i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> <strong>52 mins ago &nbsp;</strong> </i>

				</div>
			</div>
		</div>
	</div>

	<!--================================================== -->

	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
	<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{URL::to('js/plugin/pace/pace.min.js')}}"></script>

	<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

	<script>
		if (!window.jQuery) {
			document.write('<script src="{{URL::to("js/libs/jquery-2.0.2.min.js")}}"><\/script>');
		}
	</script>

	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		if (!window.jQuery.ui) {
			document.write('<script src="{{URL::to("js/libs/jquery-ui-1.10.3.min.js")}}"><\/script>');
		}
	</script>

	<!-- IMPORTANT: APP CONFIG -->
	{!! Html::script('js/app.config.js') !!}

	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
	{!! Html::script('js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') !!}

	<!-- BOOTSTRAP JS -->
	{!! Html::script('js/bootstrap/bootstrap.min.js') !!}

	<!-- CUSTOM NOTIFICATION -->
	{!! Html::script('js/notification/SmartNotification.min.js') !!}

	<!-- JARVIS WIDGETS -->
	{!! Html::script('js/smartwidgets/jarvis.widget.min.js') !!}

	<!-- EASY PIE CHARTS -->
	{!! Html::script('js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') !!}

	<!-- SPARKLINES -->
	{!! Html::script('js/plugin/sparkline/jquery.sparkline.min.js') !!}

	<!-- JQUERY VALIDATE -->
	{!! Html::script('js/plugin/jquery-validate/jquery.validate.min.js') !!}

	<!-- JQUERY MASKED INPUT -->
	<script src=""></script>
	{!! Html::script('js/plugin/masked-input/jquery.maskedinput.min.js') !!}

	<!-- JQUERY SELECT2 INPUT -->
	{!! Html::script('js/plugin/select2/select2.min.js') !!}

	<!-- JQUERY UI + Bootstrap Slider -->
	{!! Html::script('js/plugin/bootstrap-slider/bootstrap-slider.min.js') !!}

	<!-- browser msie issue fix -->
	{!! Html::script('js/plugin/msie-fix/jquery.mb.browser.min.js') !!}
	<!-- FastClick: For mobile devices -->
	{!! Html::script('js/plugin/fastclick/fastclick.min.js') !!}
	<!--[if IE 8]>

	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

	<![endif]-->

	<!-- Demo purpose only -->
	{!! Html::script('js/demo.min.js') !!}
	<!-- MAIN APP JS FILE -->

	{!! Html::script('js/app.min.js') !!}
	<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
	<!-- Voice command : plugin -->

	{!! Html::script('js/speech/voicecommand.min.js') !!}
	<!-- PAGE RELATED PLUGIN(S) -->

	<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->

	{!! Html::script('js/plugin/flot/jquery.flot.cust.min.js') !!}

	{!! Html::script('js/plugin/flot/jquery.flot.resize.min.js') !!}

	{!! Html::script('js/plugin/flot/jquery.flot.tooltip.min.js') !!}
	<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->

	{!! Html::script('js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js') !!}

	{!! Html::script('js/plugin/vectormap/jquery-jvectormap-world-mill-en.js') !!}
	<!-- Full Calendar -->

	{!! Html::script('js/plugin/fullcalendar/jquery.fullcalendar.min.js') !!}

	{!! Html::script('js/loiphat.js') !!}

	<script>
		$(document).ready(function() {

			// DO NOT REMOVE : GLOBAL FUNCTIONS!
			pageSetUp();

			/*
			 * PAGE RELATED SCRIPTS
			 */

			$(".js-status-update a").click(function() {
				var selText = $(this).text();
				var $this = $(this);
				$this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
				$this.parents('.dropdown-menu').find('li').removeClass('active');
				$this.parent().addClass('active');
			});

			/*
			* TODO: add a way to add more todo's to list
			*/

			// initialize sortable
			$(function() {
				$("#sortable1, #sortable2").sortable({
					handle : '.handle',
					connectWith : ".todo",
					update : countTasks
				}).disableSelection();
			});

			// check and uncheck
			$('.todo .checkbox > input[type="checkbox"]').click(function() {
				var $this = $(this).parent().parent().parent();

				if ($(this).prop('checked')) {
					$this.addClass("complete");

					// remove this if you want to undo a check list once checked
					//$(this).attr("disabled", true);
					$(this).parent().hide();

					// once clicked - add class, copy to memory then remove and add to sortable3
					$this.slideUp(500, function() {
						$this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
						$this.remove();
						countTasks();
					});
				} else {
					// insert undo code here...
				}

			})
			// count tasks
			function countTasks() {

				$('.todo-group-title').each(function() {
					var $this = $(this);
					$this.find(".num-of-tasks").text($this.next().find("li").size());
				});

			}

			/*
			* RUN PAGE GRAPHS
			*/

			/* TAB 1: UPDATING CHART */
			// For the demo we use generated data, but normally it would be coming from the server

			// var data = [], totalPoints = 200, $UpdatingChartColors = $("#updating-chart").css('color');

			function getRandomData() {
				if (data.length > 0)
					data = data.slice(1);

				// do a random walk
				while (data.length < totalPoints) {
					var prev = data.length > 0 ? data[data.length - 1] : 50;
					var y = prev + Math.random() * 10 - 5;
					if (y < 0)
						y = 0;
					if (y > 100)
						y = 100;
					data.push(y);
				}

				// zip the generated y values with the x values
				var res = [];
				for (var i = 0; i < data.length; ++i)
					res.push([i, data[i]])
				return res;
			}

			/* live switch */
			$('input[type="checkbox"]#start_interval').click(function() {
				if ($(this).prop('checked')) {
					$on = true;
					updateInterval = 1500;
					update();
				} else {
					clearInterval(updateInterval);
					$on = false;
				}
			});

			function update() {
				if ($on == true) {
					plot.setData([getRandomData()]);
					plot.draw();
					setTimeout(update, updateInterval);

				} else {
					clearInterval(updateInterval)
				}

			}

			var $on = false;

			data_array = {
				"US" : 4977,
				"AU" : 4873,
				"IN" : 3671,
				"BR" : 2476,
				"TR" : 1476,
				"CN" : 146,
				"CA" : 134,
				"BD" : 100
			};

			$('#vector-map').vectorMap({
				map : 'world_mill_en',
				backgroundColor : '#fff',
				regionStyle : {
					initial : {
						fill : '#c4c4c4'
					},
					hover : {
						"fill-opacity" : 1
					}
				},
				series : {
					regions : [{
						values : data_array,
						scale : ['#85a8b6', '#4d7686'],
						normalizeFunction : 'polynomial'
					}]
				},
				onRegionLabelShow : function(e, el, code) {
					if ( typeof data_array[code] == 'undefined') {
						e.preventDefault();
					} else {
						var countrylbl = data_array[code];
						el.html(el.html() + ': ' + countrylbl + ' visits');
					}
				}
			});


			/* hide default buttons */
			$('.fc-header-right, .fc-header-center').hide();

			// calendar prev
			$('#calendar-buttons #btn-prev').click(function() {
				$('.fc-button-prev').click();
				return false;
			});

			// calendar next
			$('#calendar-buttons #btn-next').click(function() {
				$('.fc-button-next').click();
				return false;
			});

			// calendar today
			$('#calendar-buttons #btn-today').click(function() {
				$('.fc-button-today').click();
				return false;
			});

			// calendar month
			$('#mt').click(function() {
				$('#calendar').fullCalendar('changeView', 'month');
			});

			// calendar agenda week
			$('#ag').click(function() {
				$('#calendar').fullCalendar('changeView', 'agendaWeek');
			});

			// calendar agenda day
			$('#td').click(function() {
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			});

			/*
			 * CHAT
			 */

			$.filter_input = $('#filter-chat-list');
			$.chat_users_container = $('#chat-container > .chat-list-body')
			$.chat_users = $('#chat-users')
			$.chat_list_btn = $('#chat-container > .chat-list-open-close');
			$.chat_body = $('#chat-body');

			/*
			* LIST FILTER (CHAT)
			*/

			// custom css expression for a case-insensitive contains()
			jQuery.expr[':'].Contains = function(a, i, m) {
				return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
			};

			function listFilter(list) {// header is any element, list is an unordered list
				// create and add the filter form to the header

				$.filter_input.change(function() {
					var filter = $(this).val();
					if (filter) {
						// this finds all links in a list that contain the input,
						// and hide the ones not containing the input while showing the ones that do
						$.chat_users.find("a:not(:Contains(" + filter + "))").parent().slideUp();
						$.chat_users.find("a:Contains(" + filter + ")").parent().slideDown();
					} else {
						$.chat_users.find("li").slideDown();
					}
					return false;
				}).keyup(function() {
					// fire the above change event after every letter
					$(this).change();
				});

			}

			// on dom ready
			listFilter($.chat_users);

			// open chat list
			$.chat_list_btn.click(function() {
				$(this).parent('#chat-container').toggleClass('open');
			})
		});

	</script>

	@yield('content_js')

	<!-- Your GOOGLE ANALYTICS CODE Below -->
	<script type="text/javascript">
		$(document).ready(function(){
			var name_route = "<?php echo $nameRoute;?>";
			$('li[data-route="'+name_route+'"]')
				.addClass('active');
			$('li[data-route="'+name_route+'"]')
				.parent()
				.css('display', 'block')
				.closest('li')
				.addClass('active open');
		});

	</script>

</body>
</html>