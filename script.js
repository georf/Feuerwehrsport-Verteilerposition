
$(function() {
	var degree_start = 135,
		cm_start = 9;

	if ($('#verteiler').length > 0) {


		var degrees = degree_start,
			verteiler = $('#verteiler'),
			degree = $('#degree'),
			degree_h = $('#degree-h'),
			cm = $('#cm'),
			cm_h = $('#cm-h'),
			meters = cm_start,

			originalPos = verteiler.offset();
			  verteiler.rotate(degrees);


			update = function() {
			  degrees = degrees % 360;
			  verteiler.rotate(degrees);
			  degree.text(degrees - degree_start);
			  degree_h.val(degrees - degree_start);
			  cm.text(meters - cm_start);
			  cm_h.val(meters - cm_start);
			  verteiler.css('left',originalPos.left + meters*2)
			  .css('top',originalPos.top);
			};


    // check for old values
    if ($('#oldDegree').length > 0) {
      degrees = degree_start + parseInt($('#oldDegree').text());
      meters = cm_start + parseInt($('#oldCm').text());
      $('select[name="team"]').val($('#oldTeam').text());
      $('input[name="name"]').val($('#oldName').text());
    }



	  $('#rotate-min').click(function() {
		degrees -= 2;
		update();
		return false;
	  });
	  $('#rotate-max').click(function() {
		degrees += 2;
		update();
		return false;
	  });
	  $('#push-min').click(function() {
		meters--;
		update();
		return false;
	  });
	  $('#push-max').click(function() {
		meters++;
		update();
		return false;
	  });

	  var checked = false;
		$('form').submit(function() {
			if (checked) return true;

			// check for name
			$.get('?page=' + $('select[name="team"]').val(), function( data ) {
				var ret = true;

				//console.log(data);

				$(data).find('span.realname').each(function() {
					if ($(this).text() == $('input[name="name"]').val()) {
						ret = false;
					}
				});

				if (ret || confirm("Willst du die aktuelle Position überschreiben?")) {
					checked = true;
					$('form').submit();
				} else {
					checked = false;
				}

				}, 'html');
			return false;
		});


	  update();

	  verteiler.css('position','absolute');

	}

	if ($('#list').length > 0) {
		var rows = $('#list tr');
		rows.each(function() {
			var tr = $(this),
				cm = parseInt(tr.find('.cm').text()),
				degree = parseInt(tr.find('.degree').text()),
				td = tr.find('.verteiler'),
				img = $('<img src="verteiler.png" alt="verteiler" style="width:100px"/>'),
				pos;

			td.append(img);
			pos = img.offset();
			img.rotate(degree + degree_start);


			img.css('left', pos.left + (cm)*2+cm_start)
				.css('top', pos.top)
				.css('position', 'absolute');


		});
	}



});
