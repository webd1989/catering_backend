{{--
  mPDF notes (why this markup looks the way it does):
  - No flexbox, no CSS grid. Every side-by-side layout is a <table>.
  - No `float` inside a styled block — the day header uses a 2-cell table.
  - @page is ignored; margins are set in the Mpdf constructor.
  - Classes must be on the element itself; descendant selectors are unreliable.
  - Use `page-break-before: always` on a div, not `break-before`.
--}}
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: dejavusanscondensed, sans-serif; font-size: 9.4pt; color: #2b2b2b; line-height: 1.45; }

  .brandwrap  { border-bottom: 0.8mm solid #8a6a2f; padding-bottom: 6px; }
  .brandtbl   { width: 100%; }
  .bname      { font-size: 19pt; font-weight: bold; color: #1c1c1c; }
  .btag       { font-size: 8pt; color: #8a6a2f; letter-spacing: 1.4px; }
  .bmeta      { font-size: 8.2pt; color: #666666; text-align: right; line-height: 1.7; }

  .doctitle   { text-align: center; margin-top: 14px; font-size: 13.5pt; font-weight: bold; color: #1c1c1c; }
  .docsub     { text-align: center; font-size: 8.6pt; color: #777777; letter-spacing: 2px; margin-bottom: 12px; }

  .sec        { font-size: 9.5pt; letter-spacing: 1.2px; color: #8a6a2f; font-weight: bold;
                margin-top: 14px; margin-bottom: 5px; padding-bottom: 3px; border-bottom: 0.2mm solid #e0d6c2; }

  table.g     { width: 100%; border-collapse: collapse; page-break-inside: avoid; }
  table.g td  { border: 0.2mm solid #d8d8d8; padding: 5px 7px; vertical-align: top; }
  table.g th  { border: 0.2mm solid #d8d8d8; padding: 5px 7px; background-color: #f4f0e8;
                font-size: 8.1pt; color: #5a4a28; font-weight: bold; text-align: left; }

  .lbl        { background-color: #faf8f4; font-weight: bold; width: 20%; color: #4a4a4a; }
  .num        { text-align: right; }
  .ctr        { text-align: center; }
  .muted      { color: #999999; font-style: italic; }
  .small      { font-size: 8pt; color: #777777; }

  .dayhdr     { width: 100%; background-color: #2b2b2b; margin-top: 9px; page-break-after: avoid; }
  .dayhdr td  { padding: 5px 8px; color: #ffffff; font-weight: bold; font-size: 9pt; border: none; }
  .dayhdr td.r{ text-align: right; font-weight: normal; color: #d8c9a5; font-size: 8.3pt; }

  .tot td     { background-color: #f4f0e8; font-weight: bold; }
  .grand td   { background-color: #2b2b2b; color: #ffffff; font-weight: bold; font-size: 10.5pt; }

  .note       { background-color: #faf8f4; border-left: 0.8mm solid #8a6a2f;
                padding: 7px 10px; font-size: 8.4pt; color: #555555; margin-top: 6px; }

  ol.t        { margin-top: 4px; padding-left: 20px; }
  ol.t li     { margin-bottom: 3px; }

  .sign       { width: 100%; margin-top: 26px; }
  .sign td    { width: 50%; padding-top: 32px; border-top: 0.2mm solid #999999;
                font-size: 8.6pt; color: #666666; }
</style>
</head>
<body>

<div class="brandwrap">
  <table class="brandtbl"><tr>
    <td>
      <div class="bname">Mamus Infustion</div>
      <div class="btag">Live Beverage & Refreshment Counters</div>
    </td>
    <td class="bmeta">
      Ref No: <b>{{$booking['id']}}</b><br>
      Date of Issue: <b>{{$booking['created_at']}}</b>
    </td>
  </tr></table>
</div>

<div class="doctitle">FUNCTION DETAILS &amp; BOOKING CONFIRMATION</div>

<div class="sec">CLIENT &amp; EVENT DETAILS</div>
<table class="g">
  <tr>
    <td class="lbl">Client Name</td><td>{{$booking['name']}}</td>
    <td class="lbl">Contact No.</td><td>{{$booking['phone']}}</td>
  </tr>
  <tr>
    <td class="lbl">Event Type</td><td>{{$booking['booking_title']}}</td>
    <td class="lbl">Email</td><td>{{$booking['email']}}</td>
  </tr>
  <tr>
    <td class="lbl">Event Dates</td>
    <td>9th – 11th December 2026 (3 Days)</td>
    <td class="lbl">City</td><td>{{ucwords($booking['location'])}}</td>
  </tr>
  <tr>
    <td class="lbl">Venues</td><td>{{$booking['address']}}</td>
    <td class="lbl">Total Functions</td>
    <td>{{$bookingEvents->count()}} Functions</td>
  </tr>
  <tr>
    <td class="lbl">Booking Status</td>
    <td colspan="3">
      <b>{{ucwords($booking['booking_status'])}}</b>
    </td>
  </tr>
</table>

<div class="sec">FUNCTION SCHEDULE</div>

@foreach ($booking['formated_events'] as $i => $day)
  <table class="dayhdr"><tr>
    <td>{{$day['formated_date']}}</td>
    <td class="r"></td>
  </tr></table>

  <table class="g">
    <tr>
      <th width="20%">Function</th>
      <th width="28%">Venue</th>
      <th width="16%">Serving Time</th>
      <th width="12%" class="ctr">Pax</th>
      <th width="12%" class="ctr">Counters</th>
      <th width="12%">Setup By</th>
    </tr>
     @foreach ($day['events'] as $f)

        <tr>
          <td><b>{{ $f->event_type_title }}</b></td>
          <td>g</td>
          <td>gf</td>
          <td class="ctr">g</td>
          <td class="ctr">g</td>
          <td>g</td>
        </tr>

    @endforeach
   
  </table>
@endforeach

</body>
</html>
