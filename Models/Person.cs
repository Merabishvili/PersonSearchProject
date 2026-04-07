namespace PersonSearchProject.Models;

public class Person
{
    public int Id { get; set; }             // Primary key
    public string Name { get; set; } = "";  
    public string Surname { get; set; } = "";
    public string PersonalNumber { get; set; } = "";
    public string Sex { get; set; } = "";
    public string Address { get; set; } = "";
}