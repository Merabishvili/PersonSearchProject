using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PersonSearchProject.Data;

namespace PersonSearchProject.Controllers;

[ApiController]
[Route("api/person")]
public class PersonController : ControllerBase
{
    private readonly AppDbContext _context;
    public PersonController(AppDbContext context) => _context = context;

    [HttpGet("search")]
    public async Task<IActionResult> Search([FromQuery] string personalNumber, [FromQuery] string surname)
    {
        var person = await _context.Persons.FirstOrDefaultAsync(p =>
            p.PersonalNumber == personalNumber && p.Surname == surname);

        if (person == null) return NotFound("Person not found");

        return Ok(person);
    }
}