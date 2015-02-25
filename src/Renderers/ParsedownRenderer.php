<?php
/**
 * The Parsedown markdown renderer implementation
 */
namespace Radic\BladeExtensions\Renderers;

use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;
use Parsedown;

/**
 * The Parsedown markdown renderer implementation
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Renderers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class ParsedownRenderer implements MarkdownRenderer
{

    /**
     * The parsedown instance
     * @var \Parsedown
     */
    protected $parsedown;

    /**
     * The config repo instance
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Constructs the class
     * @param \Parsedown $parsedown
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    function __construct(\Parsedown $parsedown, Config $config)
    {
        $this->config = $config;
        $this->parsedown = $parsedown;
    }

    /**
     * {@inheritdoc}
     * @param string $text The text
     */
    public function render($text)
    {
        return $this->parsedown->text($text);
    }
}
