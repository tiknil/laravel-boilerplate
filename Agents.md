# Agent Development Guidelines

Instructions for AI agents operating in this Laravel codebase. Adhere strictly to these guidelines.

## Project overview

Populate here the overview of your projects


## Project preferences

- Reuse code and logic as much as possible, especially when the same actions needs to be applied from multiple entrypoints
- Use basic blade templates and components for most pages
- Use livewire components when some user interaction is required (e.g. for the tables). Place the view files in the releated view directory (e.g resources/gds/<view>), not in the livewire directory.
- Use vue components as last resort for complex frontend components that require a lot of user interaction
- Typescript is mandatory for frontend code

## Environment

### Docker Environment

All PHP and Composer commands **must** be executed inside the `php-fpm` container using `docker compose` and specifying both the project name and the docker-compose file path:

The <project-name> is the name of the project folder.

```bash
docker compose --project-name <project-name> -f docker/docker-compose.yml <command>
```

To start the development environment:

```bash
docker compose --project-name <project-name> -f docker/docker-compose.yml --env-file docker/.env up -d --remove-orphans
```

To run a command inside the `php-fpm` container:

```bash
docker-compose --project-name <project-name> -f docker/docker-compose.yml exec php-fpm <command>
```

### Build & Test

- **Run all tests:** `docker-compose --project-name <project-name> -f docker/docker-compose.yml exec php-fpm composer test`
- **Frontend Build:** `yarn build`
- **Frontend Watch:** `yarn dev`

### Lint & Formatting

This project uses `Laravel Pint` for PHP code and `Prettier`/`ESLint` for JavaScript/TypeScript/Vue.

```
docker-compose --project-name <project-name> -f docker/docker-compose.yml exec php-fpm php ./vendor/bin/pint
```

## Code Style & Conventions

### PHP Code Style 

Laravel Pint with the `laravel` preset is used for PHP code.

- **Preset**: `laravel`
- **Override**: `not_operator_with_successor_space` rule is disabled.
  Full adherence to PSR standards (PSR-1, PSR-2, PSR-12) as adopted by Laravel
- **Imports**: Use fully qualified class names, one `use` statement per declaration. Alphabetize `use` statements.
- **Naming Conventions**:
  - Classes: `PascalCase`
  - Methods/Functions: `camelCase`
  - Variables: `camelCase`
  - Constants: `SCREAMING_SNAKE_CASE`
  - Properties: `camelCase` (prefer `protected` or `private`).
- **Types**: Leverage PHP's type declarations (scalar type hints, return type declarations, property types).
- **Error Handling**: Favor throwing exceptions for exceptional conditions. Catch and handle exceptions at appropriate levels

### Frontend (Vue 3 + TypeScript)

For JavaScript, TypeScript, and Vue files, formatting is handled by Prettier. Refer to the `.prettierrc.js` file for Prettier configuration.

## Rules

- **NEVER** wipe the entire database. Ask for intervention when having problems with a migration

## Specific Considerations for Agents

- **Convention Adherence**: Always analyze surrounding code to maintain consistency with existing patterns, even if they slightly deviate from general guidelines
- **Reusability**: Focus on building reusable blocks, instead of implementing similar solutions
- **Dependencies**: Before introducing new libraries or frameworks, verify their existing usage in `composer.json` (for PHP) or `package.json` (for JS/TS).
- **Comments**: Add comments sparingly, focusing on _why_ complex logic exists, not _what_ it does.
- **Security**: Always prioritize security best practices. Never expose sensitive information.

- Use the feature/ prefix when creating a new git branch
