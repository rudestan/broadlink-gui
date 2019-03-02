<?php

/* Controller/widget/Show/show.html.twig */
class __TwigTemplate_7cc8b3f537562ea615fcdb7c8235ae8801b6a12ddc8c04010819a2466dcd0cc4 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("controller/widget/base.html.twig", "Controller/widget/Show/show.html.twig", 1);
        $this->blocks = [
            'content' => [$this, 'block_content'],
            'javascript_end' => [$this, 'block_javascript_end'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return "controller/widget/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Controller/widget/Show/show.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                <span class=\"rc-title\">Philips Soundbar</span>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger rc-command\" data-rc=\"e9ee2498cea50051a1dccb1fa0200a1bf3bd0d4d\" data-cmd=\"7548ab52c3d1d595240379937e08f3e95c072312\">
                    <i class=\"rc-button fas fa-power-off\"></i>
                </div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-up\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-down\"></i></div>
            </div>
        </div>
        <div class=\"row\" style=\"margin-top: 10px;\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger rc-command\" data-rc=\"e9ee2498cea50051a1dccb1fa0200a1bf3bd0d4d\" data-cmd=\"7548ab52c3d1d595240379937e08f3e95c072312\">
                    <i class=\"rc-button fas fa-power-off\"></i>
                </div>
            </div>

        </div>
    </div>
    <div class=\"row\">
        <hr style=\"border: 1px dashed; border-color: #5a6268;width: 100%;\">
    </div>
    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                <span class=\"rc-title\">Projector BenQ</span>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger\"><i class=\"rc-button fas fa-power-off\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-up\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-down\"></i></div>
            </div>
        </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 55
    public function block_javascript_end($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascript_end"));

        // line 56
        echo "    <script src=\"/js/rc.js\" type=\"application/javascript\"></script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "Controller/widget/Show/show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 56,  101 => 55,  45 => 4,  39 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'controller/widget/base.html.twig' %}

{% block content %}
    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                <span class=\"rc-title\">Philips Soundbar</span>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger rc-command\" data-rc=\"e9ee2498cea50051a1dccb1fa0200a1bf3bd0d4d\" data-cmd=\"7548ab52c3d1d595240379937e08f3e95c072312\">
                    <i class=\"rc-button fas fa-power-off\"></i>
                </div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-up\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-down\"></i></div>
            </div>
        </div>
        <div class=\"row\" style=\"margin-top: 10px;\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger rc-command\" data-rc=\"e9ee2498cea50051a1dccb1fa0200a1bf3bd0d4d\" data-cmd=\"7548ab52c3d1d595240379937e08f3e95c072312\">
                    <i class=\"rc-button fas fa-power-off\"></i>
                </div>
            </div>

        </div>
    </div>
    <div class=\"row\">
        <hr style=\"border: 1px dashed; border-color: #5a6268;width: 100%;\">
    </div>
    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                <span class=\"rc-title\">Projector BenQ</span>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-4\">
                <div class=\"btn btn-danger\"><i class=\"rc-button fas fa-power-off\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-up\"></i></div>
            </div>
            <div class=\"col-4\">
                <div class=\"btn btn-secondary\"><i class=\"rc-button fas fa-volume-down\"></i></div>
            </div>
        </div>
    </div>
{% endblock %}

{% block javascript_end %}
    <script src=\"/js/rc.js\" type=\"application/javascript\"></script>
{% endblock %}", "Controller/widget/Show/show.html.twig", "/Users/devstan/Projects/broadlink-rm/templates/Controller/widget/Show/show.html.twig");
    }
}
