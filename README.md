# Laravel Cloud CLI

To test locally:

```sh
gh repo clone laravel/cloud-cli
cd cloud-cli
composer install
```

## Setup Alias

To use the `cloud` command from anywhere, add an alias to your shell configuration:

**For Zsh (macOS default):**

```sh
echo 'alias cloud="php '$(pwd)'/cloud"' >> ~/.zshrc
source ~/.zshrc
```

**For Bash:**

```sh
echo 'alias cloud="php '$(pwd)'/cloud"' >> ~/.bashrc
source ~/.bashrc
```

Or manually add the alias to your `~/.zshrc` or `~/.bashrc` file:

```sh
alias cloud="php /path/to/cloud-cli/cloud"
```
