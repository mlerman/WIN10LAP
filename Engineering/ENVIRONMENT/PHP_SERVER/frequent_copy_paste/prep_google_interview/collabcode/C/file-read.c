FILE *f;
int val;
f=fopen("fname","r");
if(f)
{
  while(!feof(f))
  {
    fscanf(f,"%d\n", &val);
  }
  fclose(f);
}
else
{
  printf("error, open fname\n");
}
