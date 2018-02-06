FILE *f;
int val;
f=fopen("fname","wt");
if(f)
{
  while( )
  {
    fprintf(f,"%d\n", val);
  }
  fclose(f);
}
else
{
  printf("error, create fname\n");
}
