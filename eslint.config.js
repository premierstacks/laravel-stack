/**
 * @file
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

import { EslintStack } from '@premierstacks/eslint-stack';
import globals from 'globals';

// eslint-disable-next-line no-restricted-exports
export default EslintStack.create()
  .base()
  .globals({
    ...globals.node,
    ...globals.es2024,
  })
  .ignores([...EslintStack.Selectors.GlobalIgnore])
  .ignores(['node_modules', 'vendor', '.phpunit.cache', '.phpunit.coverage', '.phpunit.result.cache', '.php-cs-fixer.cache'])
  .recommended()
  .stylistic()
  .sonarjs()
  .build();
