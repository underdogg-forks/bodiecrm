{{-- New Lead Created Notification Email --}}
  <!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <style>
    *
    {
      font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
      font-size: 100%;
      line-height: 1.6em;
      margin: 0;
      padding: 0;
    }

    img
    {
      max-width: 600px;
      width: 100%;
    }

    body
    {
      -webkit-font-smoothing: antialiased;
      height: 100%;
      -webkit-text-size-adjust: none;
      width: 100% !important;
    }

    /* -------------------------------------
    ELEMENTS
    ------------------------------------- */
    a
    {
      color: #348eda;
    }

    .btn-primary
    {
      Margin-bottom: 10px;
      width: auto !important;
    }

    .btn-primary td
    {
      background-color: #348eda;
      border-radius: 25px;
      font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
      font-size: 14px;
      text-align: center;
      vertical-align: top;
    }

    .btn-primary td a
    {
      background-color: #348eda;
      border: solid 1px #348eda;
      border-radius: 25px;
      border-width: 10px 20px;
      display: inline-block;
      color: #ffffff;
      cursor: pointer;
      font-weight: bold;
      line-height: 2;
      text-decoration: none;
    }

    .last
    {
      margin-bottom: 0;
    }

    .first
    {
      margin-top: 0;
    }

    .padding
    {
      padding: 10px 0;
    }

    /* -------------------------------------
    BODY
    ------------------------------------- */
    table.body-wrap
    {
      padding: 20px;
      width: 100%;
    }

    /* -------------------------------------
    FOOTER
    ------------------------------------- */
    table.footer-wrap
    {
      clear: both !important;
      width: 100%;
    }

    .footer-wrap .container p
    {
      color: #666666;
      font-size: 12px;
    }

    table.footer-wrap a
    {
      color: #999999;
    }

    /* -------------------------------------
    TYPOGRAPHY
    ------------------------------------- */
    h1,
    h2,
    h3
    {
      color: #111111;
      font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
      font-weight: 200;
      line-height: 1.2em;
      margin: 40px 0 10px;
    }

    h1
    {
      font-size: 36px;
    }

    h2
    {
      font-size: 28px;
    }

    h3
    {
      font-size: 22px;
    }

    p,
    ul,
    ol
    {
      font-size: 14px;
      font-weight: normal;
      margin-bottom: 10px;
    }

    ul li,
    ol li
    {
      margin-left: 5px;
      list-style-position: inside;
    }

    /* ---------------------------------------------------
    RESPONSIVENESS
    ------------------------------------------------------ */
    .container
    {
      clear: both !important;
      display: block !important;
      Margin: 0 auto !important;
      max-width: 600px !important;
    }

    .body-wrap .container
    {
      padding: 20px;
    }

    .content
    {
      display: block;
      margin: 0 auto;
      max-width: 600px;
    }

    .content table
    {
      width: 100%;
    }
  </style>
</head>

<body bgcolor="#f6f6f6">

<!-- body -->
<table class="body-wrap">
  <tr>
    <td></td>
    <td class="container" bgcolor="#FFFFFF">

      <!-- content -->
      <div class="content">
        <table>
          <tr>
            <td>
              <h3>Lead submitted for {{ $landing_page['title'] }}</h3>
            </td>
          </tr>
          <tr>
            <td>
              <a href="{{ url('leads/' . $lead['id']) }}">Click here to view the lead</a>
              <br>
              <a href="{{ url('landing_pages/' . $landing_page['id']) }}">View landing page</a>
              <br><br>
            </td>
          <tr>
          <tr>
            <td>First Name:</td>
            <td>{{ $lead['first_name'] }}</td>
          </tr>
          <tr>
            <td>Last Name:</td>
            <td>{{ $lead['last_name'] }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{ $lead['email'] }}</td>
          </tr>
          <tr>
            <td>Company</td>
            <td>{{ $lead['company'] }}</td>
          </tr>
          <tr>
            <td>Title</td>
            <td>{{ $lead['title'] }}</td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>{{ $lead['phone'] }}</td>
          </tr>
          <tr>
            <td>Zip</td>
            <td>{{ $lead['zip'] }}</td>
          </tr>
          <tr>
            <td>Address</td>
            <td>{{ $lead['address'] }}</td>
          </tr>
          <tr>
            <td>City</td>
            <td>{{ $lead['city'] }}</td>
          </tr>
          <tr>
            <td>Country</td>
            <td>{{ $lead['country'] }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <!-- /content -->

    </td>
    <td></td>
  </tr>
</table>
<!-- /body -->

</body>
</html>