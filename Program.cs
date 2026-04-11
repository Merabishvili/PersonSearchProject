using Microsoft.EntityFrameworkCore;
using PersonSearchProject.Data;

var builder = WebApplication.CreateBuilder(args);

builder.Configuration.AddJsonFile("apiconfigs.json", optional: true, reloadOnChange: true);

builder.Services.AddLogging(config =>
{
    config.ClearProviders();
    config.AddConsole();
    config.SetMinimumLevel(LogLevel.Information);
});

builder.Services.AddControllers();

builder.Services.AddDbContext<AppDbContext>(options =>
{
    var connString = builder.Configuration["DBConnection"];
    options.UseNpgsql(connString, o => o.CommandTimeout(15));
});

builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();

// Read BaseUrl from apiconfig.json and set applicationUrl
var baseUrl = builder.Configuration["BaseUrl"];
builder.WebHost.UseUrls(baseUrl);

var app = builder.Build();

app.UseSwagger();
app.UseSwaggerUI();
app.UseHttpsRedirection();
app.MapControllers();

Console.WriteLine($"API Started on {baseUrl}");
app.Run();
