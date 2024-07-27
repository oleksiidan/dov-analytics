<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Online analytics of user visits for web-projects">
    <meta name="keywords" content="Analytics, Visit, Web, Site">
    <meta name="author" content="Danyshevskyi Oleksii">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<title>DOV Analytics</title>  

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- <link rel="icon" type="image/x-icon" href="./images/favicon.ico"/> -->
    <link rel="icon" type="image/x-icon" href="/projects/analytics/app/views/img/favicon.ico"/>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <style type="text/css">
        html, body {
                    background-image: url(/projects/analytics/app/views/img/bg.jpg);
                    background-repeat: no-repeat;
                    background-position: center center;
                    background-attachment: fixed;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
        }
        .t18 {
                font-size: 18px;
        }

        .bb {
            border: 1px solid blue;
        }

        .vertical-center {
        min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
        min-height: 60vh; /* These two lines are counted as one :-)       */
        display: flex;
        align-items: center;
    }
        /* css for mod_entry */
        #nav-home-tab {
            width: 110px;
        }

    </style>
</head>
<body>
<div class="mx-auto" style="max-width: 1000px">
        
        {% block body %}{% endblock %}

</div>
    {{ include('modal/mod_add_analytics.php') }}
    {{ include('modal/mod_add_analytics_ok.php') }}
    {{ include('modal/mod_about.php') }}
    {{ include('modal/mod_entry.php') }}
    {{ include('modal/mod_analytics_view.php') }}
    {{ include('modal/mod_review.php') }}
    {{ include('modal/mod_review_ok.php') }}

<script type="text/javascript">
{{ include('js/core.js') }}
{{ include('js/analytics.js') }}
{{ include('js/mod_entry.js') }}
{{ include('js/mod_review.js') }}
</script>

{% block js %}{% endblock %}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>