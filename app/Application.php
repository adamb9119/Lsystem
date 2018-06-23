<?php

class Application extends Silex\Application
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\UrlGeneratorTrait;

    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->bootstrapAppConfig($values);
        $this->bootstrapRoutesConfig();
        $this->bootstrapTranslations();
        $this->bootstrapTwig();

    }

    public function bootstrapAppConfig(array $values)
    {
        if (empty($values['config'])) {
            throw new HttpRuntimeException('Application config is not set!');
        }

        $this->register(new \Igorw\Silex\ConfigServiceProvider($values['config']));
    }

    public function bootstrapRoutesConfig()
    {
        $this->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__ . '/configs/routes.php'));
        $this->register(new \MJanssen\Provider\RoutingServiceProvider('config.routes'));
    }

    public function bootstrapTranslations()
    {
        $this->register(new \Silex\Provider\TranslationServiceProvider(), array(
            'locale_fallback' => array('en')
        ));

        $app = $this;
    }

    public function bootstrapTwig()
    {
        $this->register(new \Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/resources/views'
        ));
    }
}
