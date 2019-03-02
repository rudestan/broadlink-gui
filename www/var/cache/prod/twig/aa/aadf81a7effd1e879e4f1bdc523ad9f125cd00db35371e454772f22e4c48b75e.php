<?php

/* controller/widget/base.html.twig */
class __TwigTemplate_54c7511911b74393f02d275555a78cac6f06606c3ebe465bc50bc15552ec5832 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'javascript_begin' => [$this, 'block_javascript_begin'],
            'content' => [$this, 'block_content'],
            'javascript_end' => [$this, 'block_javascript_end'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "controller/widget/base.html.twig"));

        // line 1
        echo "<html>
<head>
    <link rel=\"stylesheet\" href=\"/vendor/bootstrap/css/bootstrap.css\">
    <link rel=\"stylesheet\" href=\"/vendor/fontawesome/css/fontawesome.css\">
    <link rel=\"stylesheet\" href=\"/vendor/fontawesome/css/solid.css\">
    <script src=\"/vendor/jquery/jquery-3.3.1.min.js\"></script>
    <title>Remote control Widget</title>
    <style>
        .rc-button {
            width: 25px;
        }

        .rc-title {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    ";
        // line 18
        $this->displayBlock('javascript_begin', $context, $blocks);
        // line 19
        echo "</head>
<body>
    <div class=\"container\" style=\"max-width: 200px;\">
        ";
        // line 22
        $this->displayBlock('content', $context, $blocks);
        // line 23
        echo "    </div>
";
        // line 24
        $this->displayBlock('javascript_end', $context, $blocks);
        // line 25
        echo "</body>
</html>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 18
    public function block_javascript_begin($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascript_begin"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 22
    public function block_content($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 24
    public function block_javascript_end($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascript_end"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "controller/widget/base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  93 => 24,  82 => 22,  71 => 18,  62 => 25,  60 => 24,  57 => 23,  55 => 22,  50 => 19,  48 => 18,  29 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
<head>
    <link rel=\"stylesheet\" href=\"/vendor/bootstrap/css/bootstrap.css\">
    <link rel=\"stylesheet\" href=\"/vendor/fontawesome/css/fontawesome.css\">
    <link rel=\"stylesheet\" href=\"/vendor/fontawesome/css/solid.css\">
    <script src=\"/vendor/jquery/jquery-3.3.1.min.js\"></script>
    <title>Remote control Widget</title>
    <style>
        .rc-button {
            width: 25px;
        }

        .rc-title {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    {% block javascript_begin %}{% endblock %}
</head>
<body>
    <div class=\"container\" style=\"max-width: 200px;\">
        {% block content %}{% endblock %}
    </div>
{% block javascript_end %}{% endblock %}
</body>
</html>
", "controller/widget/base.html.twig", "/Users/devstan/Projects/broadlink-rm/templates/controller/widget/base.html.twig");
    }
}
