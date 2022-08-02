setInterval(function() {
  const time = new Date();
  let h = time.getHours() % 12;
  h = h == 0 ? 12 : h;
  let m = time.getMinutes();
  m = (m < 10 ? '0': '') + m;
  let s = time.getSeconds();
  s = (s < 10 ? '0': '') + s;
  let t = time.getHours() >= 12 ? 'pm' : 'am';

  // Update clock
  const months = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
  $('.time').html(`${h}:${m}:${s} ${t}<br/>${time.getDate()} ${months[time.getMonth()]}. ${time.getFullYear()}`);
}, 500);