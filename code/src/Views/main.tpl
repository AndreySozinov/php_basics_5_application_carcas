<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }}</title>
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        {% include 'site-header.tpl' %}

        <div class="container">
            {# Основное содержимое страницы #}
            <main>
                {% include content_template_name %}
            </main>

            <aside>
                {% include 'site-sidebar.tpl' %}
            </aside>
        </div>

        {% include 'site-footer.tpl' %}
    </body>
</html>