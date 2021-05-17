<?php

declare(strict_types = 1);

namespace Drupal\Tests\helfi_ahjo\Functional;

use Drupal\Tests\helfi_ahjo\Traits\MigrateTrait;
use Drupal\Tests\helfi_api_base\Functional\MigrationTestBase;

/**
 * Tests entity list functionality.
 *
 * @group helfi_ahjo
 */
class ListTest extends MigrationTestBase {

  use MigrateTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'views',
    'paatokset_ahjo',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Tests collection route (views).
   */
  public function testList() : void {
    // Make sure anonymous user can't see the entity list.
    $this->drupalGet('/admin/content/integrations/paatokset-issue');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-agenda-issues');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-policymaker');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-meeting-documents');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-meeting');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-organization');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('/admin/content/integrations/paatokset-policymaker');
    $this->assertSession()->statusCodeEquals(403);

    // Make sure logged in user with access remote entities overview permission
    // can see the entity list.
    $account = $this->createUser([
      'access remote entities overview',
      'edit remote entities',
    ]);
    $this->drupalLogin($account);
    // Migrate entities and make sure we can see all entities from fixture.
    $this->createIssueMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-issue');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createAgendaMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-agenda-issues');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createMeetingDocumentMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-policymaker');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createMeetingDocumentMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-meeting-documents');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createMeetingMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-meeting');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createOrganizationsMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-organization');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');

    $this->createPolicymakersMigration();
    $this->drupalGet('/admin/content/integrations/paatokset-policymaker');
    $this->assertSession()->pageTextContains('Displaying 1 - 20 of 40');
    $this->assertSession()->pageTextContains('Name 1');
  }

}
