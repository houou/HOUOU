<?php

class openpneConfigureDatabaseTask extends sfBaseTask
{
  protected $config = null;

  public function configure()
  {
    $this->namespace = 'openpne';
    $this->name = 'database';

    $this->addArguments(array(
      new sfCommandArgument('dbms', sfCommandArgument::OPTIONAL, 'The database type'),
      new sfCommandArgument('dbname', sfCommandArgument::OPTIONAL, 'The database name'),
      new sfCommandArgument('hostname', sfCommandArgument::OPTIONAL, 'The database hostname'),
      new sfCommandArgument('username', sfCommandArgument::OPTIONAL, 'The database username'),
      new sfCommandArgument('password', sfCommandArgument::OPTIONAL, 'The database password'),
    ));

    $this->addOptions(array(
      new sfCommandOption('app', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'all'),
      new sfCommandOption('port', null, sfCommandOption::PARAMETER_REQUIRED, 'The database port'),
      new sfCommandOption('sock', null, sfCommandOption::PARAMETER_REQUIRED, 'The database socket'),
    ));

    $this->briefDescription = 'Configure databases.yml';
  }

  protected function execute($arguments = array(), $options = array())
  {
    // update databases.yml
    if (null !== $options['app'])
    {
      $file = sfConfig::get('sf_apps_dir').'/'.$options['app'].'/config/databases.yml';
    }
    else
    {
      $file = sfConfig::get('sf_config_dir').'/databases.yml';
    }

    $this->checkArguments($arguments);

    if (!isset($arguments['dbms']))
    {
      $config = $this->doInteractiveConfig();

      if (null === $config)
      {
        $this->logSection('database', 'task aborted');
        return 1;
      }
    }
    else
    {
      $config = array();

      foreach (array('dbms', 'dbname', 'hostname', 'username', 'password') as $key)
      {
        $config[$key] = $arguments[$key];
      }

      $ret = $this->validateDBMS(new sfValidatorPass(), $config['dbms']);
      if (!$ret)
      {
        $this->logSection('database', 'task aborted');
        return 1;
      }

      foreach (array('port', 'sock') as $key)
      {
        $config[$key] = $options[$key];
      }
    }

    if ($config['dbms'] == 'sqlite')
    {
      $config['dbname'] = realpath(dirname($config['dbname'])).DIRECTORY_SEPARATOR.basename($config['dbname']);
    }

    $this->configureDatabase($file, $options['env'], $config);

    $this->logSection('database', 'databases.yml created');

    $this->config = $config;

    return 0;
  }

  protected function checkArguments($arguments)
  {
    if (!isset($arguments['dbms']))
    {
      return true;
    }

    $error = false;

    if ('sqlite' === $arguments['dbms'])
    {
      if (!isset($arguments['dbname']))
      {
        $error = true;
      }
    }
    else // mysql or pgsql
    {
      if (!isset($arguments['dbname'], $arguments['hostname'], $arguments['username']))
      {
        $error = true;
      }
    }

    if ($error)
    {
      throw new sfCommandArgumentsException(sprintf("The execution of task \"%s\" failed.\n- %s",
        $this->getFullName(), implode("\n- ", array('Not enough arguments.'))));
    }

    return true;
  }

  protected function doInteractiveConfig()
  {
    $config = array(
      'dbms' => '',
      'username' => '',
      'password' => '',
      'hostname' => '',
      'port' => '',
      'dbname' => '',
      'sock' => '',
    );

    $validator = new sfValidatorCallback(array('required' => true, 'callback' => array($this, 'validateDBMS')));
    $config['dbms'] = $this->askAndValidate(array(
      'Choose DBMS:',
      '- mysql',
      '- pgsql (unsupported)',
      '- sqlite (unsupported)'
    ), $validator, array('style' => 'QUESTION_LARGE'));

    if (!$config['dbms'])
    {
      return null;
    }

    if ($config['dbms'] !== 'sqlite')
    {
      $config['username'] = $this->askAndValidate(array('Type database username'),
        new opValidatorString(), array('style' => 'QUESTION_LARGE'));
      $config['password'] = $this->askAndValidate(array('Type database password (optional)'),
        new opValidatorString(array('required' => false)), array('style' => 'QUESTION_LARGE'));
      $config['hostname'] = $this->askAndValidate(array('Type database hostname'),
        new opValidatorString(), array('style' => 'QUESTION_LARGE'));
      $config['port'] = $this->askAndValidate(array('Type database port number (optional)'),
        new sfValidatorInteger(array('required' => false)), array('style' => 'QUESTION_LARGE'));
    }

    $config['dbname'] = $this->askAndValidate(array('Type database name'),
      new opValidatorString(), array('style' => 'QUESTION_LARGE'));

    if ($config['dbms'] == 'mysql' && ($config['hostname'] == 'localhost' || $config['hostname'] == '127.0.0.1'))
    {
      $config['sock'] = $this->askAndValidate(array('Type database socket path (optional)'),
        new opValidatorString(array('required' => false)), array('style' => 'QUESTION_LARGE'));
    }

    return $config;
  }

  public function validateDBMS($validator, $value, $arguments = array())
  {
    $list = array('mysql', 'pgsql', 'sqlite');
    if (!in_array($value, $list))
    {
      throw new sfValidatorError($validator, 'You must specify "mysql", "pgsql" or "sqlite"');
    }

    if ('mysql' !== $value)
    {
      if ($this->askConfirmation(array(
        '===================',
        ' WARNING',
        '===================',
        $value.' is UNSUPPORTED by this version of OpenPNE!',
        '',
        'DO NOT use this DBMS, unless you are expert at this DBMS and you can cope some troubles.',
        'If you want to give us some feedback about this DBMS, please visit: http://redmine.openpne.jp/',
        '',
        'Do you give up using this DBMS? (Y/n)',
        ), 'ERROR_LARGE', true)
      )
      {
        return false;
      }
    }

    return $value;
  }

  protected function configureDatabase($file, $env, $config)
  {
    $dsn = $this->createDSN($config);

    if (file_exists($file))
    {
      $ymlConfig = sfYaml::load($file);
    }

    $ymlConfig[$env]['doctrine'] = array(
      'class' => 'sfDoctrineDatabase',
      'param' => array(
        'dsn'        => $dsn,
        'username'   => $config['username'],
        'encoding'   => 'utf8',
        'attributes' => array(
           Doctrine::ATTR_USE_DQL_CALLBACKS => true,
        ),
      ),
    );

    if ($config['password'])
    {
      $ymlConfig[$env]['doctrine']['param']['password'] = $config['password'];
    }

    file_put_contents($file, sfYaml::dump($ymlConfig, 4));
  }

  protected function createDSN($config)
  {
    $result = $config['dbms'].':';

    $data = array();

    if ($config['dbname'])
    {
      if ($config['dbms'] === 'sqlite')
      {
        $data[] = $config['dbname'];
      }
      else
      {
        $data[] = 'dbname='.$config['dbname'];
      }
    }

    if ($config['hostname'])
    {
      $data[] = 'host='.$config['hostname'];
    }

    if ($config['port'])
    {
      $data[] = 'port='.$config['port'];
    }

    if ($config['sock'])
    {
      $data[] = 'unix_socket='.$config['sock'];
    }

    $result .= implode(';', $data);
    return $result;
  }

  public function getConfig()
  {
    return $this->config;
  }
}
