<?php

/**
 * @file Contains the code to generate drush commands
 */

/**
 * Implements hook_drush_command().
 */
function fruits_drush_command() {
  $commands['clear-fruits'] = [
    'description' => 'This command will remove all fruits. This command is intendend for development.',
    'aliases' => ['cf'],
    'examples' => [
      'drush clear-fruits' => 'Removes everything.',
    ],
  ];

  return $commands;
}

/**
 * Drush command logic.
 */
function drush_fruits_clear_fruits() {

  $fruits_ids = \Drupal::entityQuery('fruits')->execute();
  entity_delete_multiple('fruits', $fruits_ids);
  drush_print('All fruits have been removed.');

}
