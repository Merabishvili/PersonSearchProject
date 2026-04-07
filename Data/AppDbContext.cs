using Microsoft.EntityFrameworkCore;
using PersonSearchProject.Models;

namespace PersonSearchProject.Data;

public class AppDbContext : DbContext
{
    public AppDbContext(DbContextOptions<AppDbContext> options) : base(options) {}

    public DbSet<Person> Persons => Set<Person>();
}