<?php

require_once 'PEAR/PackageFileManager.php';

$version = '1.0.1';
$notes = <<<EOT
- aligned _modifyQuery() signature and phpdoc
- fix bug sqlite:///:memory: trys to open file (bug #6599)
- added 'result_introspection' supported metadata support
- properly quote table names in tableInfo() (related to bug #6573)
- use connected_server_info in getServerVersion() as a cache cache
- use parent::disconnect() in disconnect()
- added server_version option
- set error code in all raiseError() calls
- added support for length in integer reverse engineering
- some fixes regarding boolean reverse engineering
- protect against sql injection in the reverse and manager module

open todo items:
- a number of the manager test cases fail because sqlite does not support adding
  primary keys to existing tables
- the alter table tests fails because this is unsupported in sqlite2
- the test replace test fails because sqlite reports an incorrect affected rows
  value when no existing data was replaced
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(
    array(
        'packagefile'       => 'package_sqlite.xml',
        'package'           => 'MDB2_Driver_sqlite',
        'summary'           => 'sqlite MDB2 driver',
        'description'       => 'This is the SQLite MDB2 driver.',
        'version'           => $version,
        'state'             => 'stable',
        'license'           => 'BSD License',
        'filelistgenerator' => 'cvs',
        'include'           => array('*sqlite*'),
        'ignore'            => array('package_sqlite.php'),
        'notes'             => $notes,
        'changelogoldtonew' => false,
        'simpleoutput'      => true,
        'baseinstalldir'    => '/',
        'packagedirectory'  => './',
        'dir_roles'         => array(
            'docs' => 'doc',
             'examples' => 'doc',
             'tests' => 'test',
             'tests/templates' => 'test',
        ),
    )
);

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->addMaintainer('lsmith', 'lead', 'Lukas Kahwe Smith', 'smith@pooteeweet.org');

$package->addDependency('php', '4.3.0', 'ge', 'php', false);
$package->addDependency('PEAR', '1.0b1', 'ge', 'pkg', false);
$package->addDependency('MDB2', '2.0.1', 'ge', 'pkg', false);
$package->addDependency('sqlite', null, 'has', 'ext', false);

$package->addglobalreplacement('package-info', '@package_version@', 'version');

if (array_key_exists('make', $_GET) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
