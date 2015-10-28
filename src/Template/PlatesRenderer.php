<?php
namespace SixTool\Template;

use League\Plates\Engine;

class PlatesRenderer implements TemplateRendererInterface
{
    private $template;

    public function __construct(Engine $template = null)
    {
        if (null === $template) {
            $template = $this->createTemplate();
        }
        $this->template = $template;
    }

    /**
     * Render
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function render($name, $params = [])
    {
        return $this->template->render($name, $params);
    }

    /**
     * {@inheritDoc}
     *
     * Proxies to the Plate Engine's `addData()` method.
     *
     * {@inheritDoc}
     */
    public function addDefaultParam($templateName, $param, $value)
    {
        if (! is_string($templateName) || empty($templateName)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '$templateName must be a non-empty string; received %s',
                (is_object($templateName) ? get_class($templateName) : gettype($templateName))
            ));
        }

        if (! is_string($param) || empty($param)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '$param must be a non-empty string; received %s',
                (is_object($param) ? get_class($param) : gettype($param))
            ));
        }

        $params = [$param => $value];

        if ($templateName === self::TEMPLATE_ALL) {
            $templateName = null;
        }

        $this->template->addData($params, $templateName);
    }

    /**
     * Create a default Plates engine
     *
     * @params string $path
     * @return Engine
     */
    private function createTemplate()
    {
        return new Engine();
    }
}