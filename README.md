# Patabase

R&D project that implements a very basic filesystem based database in PHP.

## Usage

1. Clone the repo somewhere locally
2. Update `PATABASE_DIR` to point to a locally writable directory
3. Run `composer install`
4. Un-comment the db initialisation in `src/Command/TestDbCommand.php`
5. Run the test command `php bin/console app:test-db`

## Example Output

Query results

![Screenshot from 2023-09-04 08-52-32.png](Screenshot%20from%202023-09-04%2008-52-32.png)

Database file structure

![Screenshot from 2023-09-04 08-54-13.png](Screenshot%20from%202023-09-04%2008-54-13.png)