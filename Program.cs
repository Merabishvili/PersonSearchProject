using Microsoft.EntityFrameworkCore;
using PersonSearchProject.Data;

var builder = WebApplication.CreateBuilder(args);

builder.Configuration.AddJsonFile("apiconfigs.json", optional: false, reloadOnChange: true);

builder.Services.AddLogging(config =>
{
    config.ClearProviders();
    config.AddConsole();
    config.SetMinimumLevel(LogLevel.Information);
});

builder.Services.AddControllers();

var connString = builder.Configuration["DBConnection"];
var baseUrl = builder.Configuration["BaseUrl"];

if (string.IsNullOrWhiteSpace(connString))
    throw new Exception("DBConnection is missing from apiconfigs.json");

if (string.IsNullOrWhiteSpace(baseUrl))
    throw new Exception("BaseUrl is missing from apiconfigs.json");

Console.WriteLine($"Loaded BaseUrl: {baseUrl}");
Console.WriteLine($"Loaded DBConnection: {connString}");

builder.Services.AddDbContext<AppDbContext>(options =>
{
    options.UseNpgsql(connString, o => o.CommandTimeout(15));
});

builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();

builder.Services.AddCors(options =>
{
    options.AddPolicy("AllowFrontend", policy =>
    {
        policy.AllowAnyOrigin()
              .AllowAnyHeader()
              .AllowAnyMethod();
    });
});

builder.WebHost.UseUrls(baseUrl);

var app = builder.Build();

app.UseSwagger();
app.UseSwaggerUI();
app.UseCors("AllowFrontend");
// app.UseHttpsRedirection();   // keep disabled for now
app.MapControllers();

Console.WriteLine($"API Started on {baseUrl}");
app.Run();
