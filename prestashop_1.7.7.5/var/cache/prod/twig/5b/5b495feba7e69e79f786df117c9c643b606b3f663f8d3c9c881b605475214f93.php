<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @PrestaShop/Admin/Common/Grid/Actions/Grid/simple.html.twig */
class __TwigTemplate_48385d35f016565f71e511ae248b1f0424d7dc2b9f26ffafca180abf504cc657 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "
<button type=\"button\"
        id=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute(($context["grid"] ?? null), "id", []), "html", null, true);
        echo "_grid_action_";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "id", []), "html", null, true);
        echo "\"
        class=\"dropdown-item js-";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "id", []), "html", null, true);
        echo "-grid-action\"
>
  ";
        // line 30
        if ( !twig_test_empty($this->getAttribute(($context["action"] ?? null), "icon", []))) {
            // line 31
            echo "    <i class=\"material-icons\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "icon", []), "html", null, true);
            echo "</i>
  ";
        }
        // line 33
        echo "  ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["action"] ?? null), "name", []), "html", null, true);
        echo "
</button>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Common/Grid/Actions/Grid/simple.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 33,  47 => 31,  45 => 30,  40 => 28,  34 => 27,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Common/Grid/Actions/Grid/simple.html.twig", "/var/www/html/prestashop_1.7.7.5/src/PrestaShopBundle/Resources/views/Admin/Common/Grid/Actions/Grid/simple.html.twig");
    }
}
