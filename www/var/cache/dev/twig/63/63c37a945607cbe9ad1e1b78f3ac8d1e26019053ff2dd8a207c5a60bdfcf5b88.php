<?php

/* controller/widget/Show/show.html.twig */
class __TwigTemplate_14989c99dcd9cf160c4511b2f63cf32cf738c8adb723bb7e314aa2a26cc24d88 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("controller/widget/base.html.twig", "controller/widget/Show/show.html.twig", 1);
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "controller/widget/Show/show.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "controller/widget/Show/show.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["remotes"]) || array_key_exists("remotes", $context) ? $context["remotes"] : (function () { throw new Twig_Error_Runtime('Variable "remotes" does not exist.', 4, $this->source); })()));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["remote"]) {
            // line 5
            echo "        <div class=\"row\">
            <div class=\"row\">
                <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                    <span class=\"rc-title\">";
            // line 8
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["remote"], "name", []), "html", null, true);
            echo "</span>
                </div>
            </div>
            <div class=\"row";
            // line 11
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["remote"], "commands", [])) == 1)) {
                echo " col-12";
            }
            echo "  align-content-lg-center\">
                ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["remote"], "commands", []));
            foreach ($context['_seq'] as $context["_key"] => $context["command"]) {
                // line 13
                echo "                    <div class=\"col-4\" style=\"padding-top: 10px;\">
                        <div class=\"btn ";
                // line 14
                if ((twig_get_attribute($this->env, $this->source, $context["command"], "color_class", []) != null)) {
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["command"], "color_class", []), "html", null, true);
                } else {
                    echo "btn-secondary";
                }
                echo " rc-command\" data-rc=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["remote"], "id", []), "html", null, true);
                echo "\" data-cmd=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["command"], "id", []), "html", null, true);
                echo "\">
                            ";
                // line 15
                if ((twig_get_attribute($this->env, $this->source, $context["command"], "icon_class", []) != null)) {
                    // line 16
                    echo "                                <i class=\"rc-button fas ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["command"], "icon_class", []), "html", null, true);
                    echo "\"></i>
                            ";
                } else {
                    // line 18
                    echo "                                <span class=\"rc-button\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["command"], "name", []), "html", null, true);
                    echo "</span>
                            ";
                }
                // line 20
                echo "                        </div>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['command'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            echo "            </div>
        </div>
        ";
            // line 25
            if ((twig_get_attribute($this->env, $this->source, $context["loop"], "last", []) == false)) {
                // line 26
                echo "            <div class=\"row\">
                <hr style=\"border: 1px dashed; border-color: #5a6268;width: 100%;\">
            </div>
        ";
            }
            // line 30
            echo "    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['remote'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 33
    public function block_javascript_end($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascript_end"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascript_end"));

        // line 34
        echo "    <script src=\"/js/rc.js\" type=\"application/javascript\"></script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "controller/widget/Show/show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  173 => 34,  164 => 33,  142 => 30,  136 => 26,  134 => 25,  130 => 23,  122 => 20,  116 => 18,  110 => 16,  108 => 15,  96 => 14,  93 => 13,  89 => 12,  83 => 11,  77 => 8,  72 => 5,  54 => 4,  45 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'controller/widget/base.html.twig' %}

{% block content %}
    {% for remote in remotes %}
        <div class=\"row\">
            <div class=\"row\">
                <div class=\"col-sm\" style=\"padding-bottom: 4px;\">
                    <span class=\"rc-title\">{{ remote.name }}</span>
                </div>
            </div>
            <div class=\"row{% if remote.commands|length == 1 %} col-12{% endif %}  align-content-lg-center\">
                {% for command in remote.commands %}
                    <div class=\"col-4\" style=\"padding-top: 10px;\">
                        <div class=\"btn {% if command.color_class != null %}{{ command.color_class }}{% else %}btn-secondary{% endif %} rc-command\" data-rc=\"{{ remote.id }}\" data-cmd=\"{{ command.id }}\">
                            {% if command.icon_class != null %}
                                <i class=\"rc-button fas {{ command.icon_class -}}\"></i>
                            {% else %}
                                <span class=\"rc-button\">{{ command.name }}</span>
                            {% endif %}
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>
        {% if loop.last == false %}
            <div class=\"row\">
                <hr style=\"border: 1px dashed; border-color: #5a6268;width: 100%;\">
            </div>
        {% endif %}
    {% endfor %}
{% endblock %}

{% block javascript_end %}
    <script src=\"/js/rc.js\" type=\"application/javascript\"></script>
{% endblock %}", "controller/widget/Show/show.html.twig", "/Users/devstan/Projects/broadlink-rm/templates/controller/widget/Show/show.html.twig");
    }
}
